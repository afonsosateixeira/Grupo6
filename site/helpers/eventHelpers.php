<?php
const MONTH_FULL = [1=>'Janeiro', 2=>'Fevereiro', 3=>'Março', 4=>'Abril', 5=>'Maio', 6=>'Junho', 7=>'Julho', 8=>'Agosto', 9=>'Setembro', 10=>'Outubro', 11=>'Novembro', 12=>'Dezembro'];
const MONTH_SHORT = ['01'=>'JAN', '02'=>'FEV', '03'=>'MAR', '04'=>'ABR', '05'=>'MAI', '06'=>'JUN', '07'=>'JUL', '08'=>'AGO', '09'=>'SET', '10'=>'OUT', '11'=>'NOV', '12'=>'DEZ'];

function getEventCoverImage(?string $name, ?string $type): string {
    $haystack = strtolower(trim(($type ?? '') . ' ' . ($name ?? '')));
    return match(true) {
        str_contains($haystack, 'cãominhada') || str_contains($haystack, 'caominhada') || str_contains($haystack, 'caminhada') => 'assets/img/home_yara.jpg',
        str_contains($haystack, 'adoção') || str_contains($haystack, 'adocao') || str_contains($haystack, 'feira') => 'assets/img/home_zeus.webp',
        str_contains($haystack, 'volunt') || str_contains($haystack, 'palestra') => 'assets/img/dia_voluntario_banner1.png',
        str_contains($haystack, 'treino') || str_contains($haystack, 'workshop') => 'assets/img/home_mike.avif',
        str_contains($haystack, 'campanha') || str_contains($haystack, 'fundos') => 'assets/img/home_lost_animals.png',
        default => 'assets/img/poppy_max.png'
    };
}

function getStatusLabel(string $status): string {
    return match($status) {
        'scheduled' => 'Agendado',
        'completed' => 'Concluído',
        'cancelled' => 'Cancelado',
        default => 'Adiado'
    };
}

function getStatusClass(string $status): string {
    return match($status) {
        'scheduled' => 'is-scheduled',
        'completed' => 'is-completed',
        'cancelled' => 'is-cancelled',
        default => 'is-postponed'
    };
}
