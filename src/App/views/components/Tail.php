</body>
<script>
    const eye = document.getElementById('eye');
    const eyeSlash = document.getElementById('eye-slash');
    const password = document.querySelector('input[type="password"]');
    const eyeConfirm = document.getElementById('eye-confirm');
    const eyeSlashConfirm = document.getElementById('eye-slash-confirm');
    const passwordConfirm = document.querySelectorAll('input[type="password"]')[1];
    eye.addEventListener("click",()=>{
        eye.classList.add("hidden");
        eyeSlash.classList.remove("hidden");
        password.type = "password";
    });
    eyeSlash.addEventListener("click",()=>{
        eyeSlash.classList.add("hidden");
        eye.classList.remove("hidden");
        password.type = "text";
    });
    eyeConfirm.addEventListener("click",()=>{
        eyeConfirm.classList.add("hidden");
        eyeSlashConfirm.classList.remove("hidden");
        passwordConfirm.type = "password";
    });
    eyeSlashConfirm.addEventListener("click",()=>{
        eyeSlashConfirm.classList.add("hidden");
        eyeConfirm.classList.remove("hidden");
        passwordConfirm.type = "text";
    });
</script>

</html>