@component('mail::message')
# Добро пожаловать в Event Horizon! 🎉

Спасибо за регистрацию! Для завершения процесса регистрации и активации вашего аккаунта, пожалуйста, подтвердите ваш email-адрес.

@component('mail::button', ['url' => $verificationUrl, 'color' => 'primary'])
Подтвердить email
@endcomponent

Если вы не регистрировались на нашем сайте, просто проигнорируйте это письмо.

С уважением,<br>
Команда Event Horizon
@endcomponent