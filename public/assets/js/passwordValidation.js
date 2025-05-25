const passwordInput = document.getElementById('password')
const togglePasswordButton = document.getElementById('togglePassword')
const eyeIcon = document.getElementById('eyeIcon')
const passwordStrengthMeter = document.getElementById('passwordStrengthMeter')
const passwordStrengthBar = document.getElementById('passwordStrengthBar')
const passwordStrengthText = document.getElementById('passwordStrengthText')
const confirmPasswordInput = document.getElementById('confirm_password')
const toggleConfirmPasswordButton = document.getElementById('toggleConfirmPassword')
const confirmEyeIcon = document.getElementById('confirmEyeIcon')
const passwordMatchError = document.getElementById('passwordMatchError')
const form = document.getElementById('passwordStrengthForm')

togglePasswordButton.addEventListener('click', () => {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password'
    passwordInput.setAttribute('type', type)
    eyeIcon.className = type === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash'
})

toggleConfirmPasswordButton.addEventListener('click', () => {
    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password'
    confirmPasswordInput.setAttribute('type', type)
    confirmEyeIcon.className = type === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash'
})

passwordInput.addEventListener('input', () => {
    const result = zxcvbn(passwordInput.value)
    const score = result.score
    const width = (score / 4) * 100 + '%'
    passwordStrengthBar.style.width = width


    if (score === 0) {
        passwordStrengthBar.className = 'bg-red-500 h-2.5 rounded-full'
        passwordStrengthText.textContent = 'Very weak'
        passwordStrengthText.className = 'mt-2 text-sm text-red-500 dark:text-red-400'
    } else if (score === 1) {
        passwordStrengthBar.className = 'bg-orange-500 h-2.5 rounded-full'
        passwordStrengthText.textContent = 'Weak'
        passwordStrengthText.className = 'mt-2 text-sm text-orange-500 dark:text-orange-400'
    } else if (score === 2) {
        passwordStrengthBar.className = 'bg-yellow-500 h-2.5 rounded-full'
        passwordStrengthText.textContent = 'Medium'
        passwordStrengthText.className = 'mt-2 text-sm text-yellow-500 dark:text-yellow-400'
    } else if (score === 3) {
        passwordStrengthBar.className = 'bg-lime-500 h-2.5 rounded-full'
        passwordStrengthText.textContent = 'Strong'
        passwordStrengthText.className = 'mt-2 text-sm text-lime-500 dark:text-lime-400'
    } else if (score === 4) {
        passwordStrengthBar.className = 'bg-green-500 h-2.5 rounded-full'
        passwordStrengthText.textContent = 'Very strong'
        passwordStrengthText.className = 'mt-2 text-sm text-green-500 dark:text-green-400'
    }
})

confirmPasswordInput.addEventListener('input', () => {
    if (passwordInput.value !== confirmPasswordInput.value) {
        passwordMatchError.classList.remove('hidden')
    } else {
        passwordMatchError.classList.add('hidden')
    }
})

form.addEventListener('submit', (event) => {
    const passwordScore = zxcvbn(passwordInput.value).score
    if (passwordScore < 3) {
        event.preventDefault() // Empêche la soumission
        alert('Please enter a strong password.')
    } else if (passwordInput.value !== confirmPasswordInput.value) {
        event.preventDefault()
        passwordMatchError.classList.remove('hidden')
    }
})
