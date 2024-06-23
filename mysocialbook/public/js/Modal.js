document.addEventListener("DOMContentLoaded", () => {
    SetModalScript();
    SetTextAreaScript();
    SetUploadScript();
});

function ToggleBlockDisplay(element)
{
    element.classList.contains('d-none') 
        ? SetDisplayBlock(element)
        : SetDisplayNone(element);
}

function SetDisplayBlock(element)
{
    element.classList.remove('d-none');
    element.classList.remove('d-flex');
    element.classList.add('d-block');
}

function SetDisplayNone(element)
{
    element.classList.remove('d-block');
    element.classList.remove('d-flex');
    element.classList.add('d-none');
}

function SetModalScript()
{
    var modal = document.getElementById("new-thread-modal");
    var btn = document.getElementById("new-thread");

    btn.onclick = () => {
        SetDisplayBlock(modal);
    }

    window.onclick = (event) => {
        if (event.target == modal) {
            SetDisplayNone(modal);
            ResetNewThreadForm();
        }
    }
}

function SetTextAreaScript()
{
    const textarea = document.getElementById('new-thread-input-text');
    const publishBtn = document.getElementById('submit-thread');
    
    textarea.addEventListener('input', () => {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';

        if (textarea.value.length > 0) {
            publishBtn.classList.remove('btn-disabled');
            publishBtn.disabled = false;
        } else if(textarea.value.length == 0 && FileUploaderIsEmpty()) {
            publishBtn.classList.add('btn-disabled');
            publishBtn.disabled = true;
        }
    });
}

function SetUploadScript()
{
    const uploadButton = document.getElementById('upload-button');
    const fileInput = document.getElementById('file-input');
    const imagePreview = document.getElementById('image-preview');
    const removeImageButton = document.getElementById('remove-image-button');
    const publishBtn = document.getElementById('submit-thread');
    const form = document.getElementById('thread-form');

    uploadButton.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];

        if (file && (file.type === 'image/jpeg' || file.type === 'image/png'))
        {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                SetDisplayBlock(imagePreview);
                SetDisplayNone(uploadButton);
                SetDisplayBlock(removeImageButton);

                publishBtn.classList.remove('btn-disabled');
                publishBtn.disabled = false;
            };
            reader.readAsDataURL(file);
        } 
        else 
        {
            alert('Per favore carica un file JPG o PNG.');
            fileInput.value = "";
            SetDisplayNone(imagePreview);
        }
    });

    removeImageButton.addEventListener('click', () => {
        fileInput.value = "";
        imagePreview.src = "";
        SetDisplayBlock(uploadButton);
        SetDisplayNone(imagePreview);
        SetDisplayNone(removeImageButton);

        if(TextAreaIsEmpty()) {
            publishBtn.classList.add('btn-disabled');
            publishBtn.disabled = true;
        }
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        var formData = new FormData(form);
        var modal = document.getElementById("new-thread-modal");

        try
        {
            var result = await fetch('http://127.0.0.1:8000/posts/upload', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json());

            if (result.isSuccess)
            {
                SetDisplayNone(modal);
                ResetNewThreadForm();
                alert('Post salvato con successo');
            }

        } catch (error)
        {
            alert('Errore durante il salvataggio di un thread');
        }

    });
}

function ResetNewThreadForm() {
    const textarea = document.getElementById('new-thread-input-text');
    textarea.value = "";

    const fileInput = document.getElementById('file-input');
    fileInput.value = "";

    const imagePreview = document.getElementById('image-preview');
    imagePreview.src = "";
    SetDisplayNone(imagePreview);

    const removeImageButton = document.getElementById('remove-image-button');
    SetDisplayNone(removeImageButton);
}

function TextAreaIsEmpty()
{
    const textarea = document.getElementById('new-thread-input-text');
    return textarea.value.length == 0;
}

function FileUploaderIsEmpty()
{
    const fileInput = document.getElementById('file-input');
    return fileInput.value.length == 0;
}