document.addEventListener('DOMContentLoaded', function() {
    SetUploadScript();

    //Toggle Password listeners
    AddPwdOnClickListener('pwd-div', 'password');
    AddPwdOnClickListener('pwd-confirm-div', 'password-confirm');

    //Email validation
    var emailInput = document.getElementById('email');
    emailInput.addEventListener('input', validateEmail);

    //Username validation
    var usernameInput = document.getElementById('username');
    usernameInput.addEventListener('input', () => {
        if(usernameInput.value.length == 0){
            resetFeedbackSpan('username-feedback');
            return;
        }

        if(!validateUsername()) {
            setKoFeedbackMessage('username-feedback', 'Lo Username deve essere di almeno 6 caratteri.');
            return;
        }
            
        checkIfUserAlreadyExists(usernameInput.value);
    });

    //Password validation
    var passwordInput = document.getElementById('password');
    passwordInput.addEventListener('input', () => {
        validatePassword(); 
        validateConfirmPassword();
    });

    //Password-confirm validation
    var confirmPasswordInput = document.getElementById('password-confirm');
    confirmPasswordInput.addEventListener('input', validateConfirmPassword);
});

function checkIfUserAlreadyExists(username)
{
    fetch('users/checkExistingUser/' + encodeURIComponent(username))
        .then(response => response.json())
        .then(data => {
            data.message === 'OK'
                ? resetFeedbackSpan('username-feedback')
                : setKoFeedbackMessage('username-feedback', 'Username già in uso.');
        })
        .catch(error => {
            console.error('Si è verificato un errore:', error);
        });
}

function setOkFeedbackMessage(id, message)
{
    var usernameFeedBack = document.getElementById(id);
    usernameFeedBack.textContent = message;

    if(usernameFeedBack.classList.contains("ko"))
        usernameFeedBack.classList.remove("ko");

    usernameFeedBack.classList.add("ok");
}

function setKoFeedbackMessage(id, message)
{
    var usernameFeedBack = document.getElementById(id);
    usernameFeedBack.textContent = message;

    if(usernameFeedBack.classList.contains("ok"))
        usernameFeedBack.classList.remove("ok");

    usernameFeedBack.classList.add("ko");
}

function resetFeedbackSpan(id)
{
    var feedBack = document.getElementById(id);
    
    if(feedBack.classList.contains("ok"))
        feedBack.classList.remove("ok");
    
    if(feedBack.classList.contains("ko"))
        feedBack.classList.remove("ko");
}

function validateEmail() {
    var emailInput = document.getElementById('email');
    var emailFeedback = document.getElementById('email-feedback');
    if(emailInput.value.length == 0){
        resetFeedbackSpan(emailFeedback.id);
        return;
    }

    var email = emailInput.value.trim();
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        setKoFeedbackMessage(emailFeedback.id, "Email non valida");
        return;
    }

    resetFeedbackSpan(emailFeedback.id);
}

function validateUsername()
{
    var usernameInput = document.getElementById('username');
    return usernameInput.value.length >= 6;
}

function validatePassword() {
    var passwordInput = document.getElementById('password');
    var passwordFeedback = document.getElementById('password-feedback');
    var password = passwordInput.value.trim();
    var lowercaseRegex = /[a-z]/;
    var uppercaseRegex = /[A-Z]/;
    var numberRegex = /[0-9]/;
    var specialCharacters = "!@#$%^&*()_+}{\":;?/>.<,";
    var containsLowercase = lowercaseRegex.test(password);
    var containsUppercase = uppercaseRegex.test(password);
    var containsNumber = numberRegex.test(password);
    var containsSpecialCharacter = [...specialCharacters].some(character => password.includes(character));

    if (password.length == 0) {
        resetFeedbackSpan(passwordFeedback.id);
        return;
    }

    if (password.length < 8) {
        setKoFeedbackMessage(passwordFeedback.id, "La password deve essere di almeno 8 caratteri");
        return;
    }

    if (!containsLowercase) {
        setKoFeedbackMessage(passwordFeedback.id, "La password deve contenere almeno una lettera minuscola");
        return;
    }

    if (!containsUppercase) {
        setKoFeedbackMessage(passwordFeedback.id, "La password deve contenere almeno una lettera maiuscola");
        return;
    }

    if (!containsNumber) {
        setKoFeedbackMessage(passwordFeedback.id, "La password deve contenere almeno un numero");
        return;
    }

    if (!containsSpecialCharacter) {
        setKoFeedbackMessage(passwordFeedback.id, "La password deve contenere almeno un carattere speciale");
        return;
    }

    resetFeedbackSpan(passwordFeedback.id);
}


function validateConfirmPassword() {
    var passwordInput = document.getElementById('password');
    var confirmPasswordInput = document.getElementById('password-confirm');
    var confirmPasswordFeedback = document.getElementById('password-confirm-feedback');
    if(confirmPasswordInput.value.length == 0){
        resetFeedbackSpan(confirmPasswordFeedback.id);
        return;
    }

    var confirmPassword = confirmPasswordInput.value.trim();
    var password = passwordInput.value.trim();

    if (password !== confirmPassword) {
        setKoFeedbackMessage(confirmPasswordFeedback.id, "Le password non corrispondono.");
        return;
    }

    resetFeedbackSpan(confirmPasswordFeedback.id);
}

function AddPwdOnClickListener(callerId, targetId)
{
    var div = document.getElementById(callerId);

    div.addEventListener("click", () => {
        togglePassword(div, targetId);
    });
}

function togglePassword(caller, targetId)
{
    var target = document.getElementById(targetId);
    target.type = target.type == 'password' ? 'text' : 'password';
    caller.textContent = target.type == 'password' ? 'Mostra' : 'Nascondi';
}

function SetUploadScript()
{
    const uploadButton = document.getElementById('upload-button');
    const fileInput = document.getElementById('file-input');
    const imagePreview = document.getElementById('image-preview');
    const removeImageButton = document.getElementById('remove-image-button');

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
    });
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