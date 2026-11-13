{{--
    Переопределение футера Orchid (platform::footer).

    На странице входа (гость) никаких «Crafted with…», текста про MIT-лицензию
    и внешних ссылок не показываем. Для авторизованных пользователей оставляем
    прежний минимальный футер (версия платформы).
--}}
@auth
    <div class="text-center user-select-none my-4 d-none d-lg-block">
        <p class="small mb-0">
            {{ __('Version') }}: {{\Orchid\Platform\Dashboard::version()}}
        </p>
    </div>
@endauth
