<?php

namespace App;

enum EmailType: string
{
    case WELCOME_EMAIL = 'welcome_email';
    case PASSWORD_RESET = 'password_reset';
    case NEWSLETTER = 'newsletter';
    case ORDER_CONFIRMATION = 'order_confirmation';
    case ACCOUNT_DEACTIVATION = 'account_deactivation';

    public function getSubject(): string
    {
        return match ($this) {
            self::WELCOME_EMAIL => 'Welcome to our platform!',
            self::PASSWORD_RESET => 'Password Reset Request',
            self::NEWSLETTER => 'Monthly Newsletter',
            self::ORDER_CONFIRMATION => 'Order Confirmation',
            self::ACCOUNT_DEACTIVATION => 'Account Deactivation Notice',
        };
    }

    public function getTemplateName(): string
    {
        return match ($this) {
            self::WELCOME_EMAIL => 'emails.new-mail',
            self::PASSWORD_RESET => 'emails.password_reset',
            self::NEWSLETTER => 'emails.newsletter',
            self::ORDER_CONFIRMATION => 'emails.order_confirmation',
            self::ACCOUNT_DEACTIVATION => 'emails.account_deactivation',
        };
    }
}
