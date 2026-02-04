<?php

namespace App\Helpers;

use DateTime;

class DateHelper
{
    /**
     * Formata uma data para o formato dd-mm-yyyy
     *
     * @param string|null $date Data no formato ISO ou qualquer formato válido
     * @param string $format Formato de saída (padrão: dd-mm-yyyy)
     * @return string Data formatada ou string vazia se inválida
     */
    public static function formatDate($date, string $format = 'd/m/Y'): string
    {
        if (empty($date)) {
            return '';
        }

        try {
            $dateTime = new DateTime($date);
            return $dateTime->format($format);
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Formata uma data para o formato brasileiro (dd/mm/yyyy)
     *
     * @param string|null $date Data no formato ISO ou qualquer formato válido
     * @return string Data formatada ou string vazia se inválida
     */
    public static function formatBrazilianDate($date): string
    {
        return self::formatDate($date, 'd/m/Y');
    }

    /**
     * Formata uma data e hora para o formato brasileiro
     *
     * @param string|null $datetime Data e hora no formato ISO
     * @return string Data e hora formatada
     */
    public static function formatBrazilianDateTime($datetime): string
    {
        return self::formatDate($datetime, 'd/m/Y H:i:s');
    }

    /**
     * Retorna apenas o dia da data
     *
     * @param string|null $date Data no formato ISO
     * @return string Dia
     */
    public static function getDay($date): string
    {
        return self::formatDate($date, 'd');
    }

    /**
     * Retorna apenas o mês da data
     *
     * @param string|null $date Data no formato ISO
     * @return string Mês
     */
    public static function getMonth($date): string
    {
        return self::formatDate($date, 'm');
    }

    /**
     * Retorna apenas o ano da data
     *
     * @param string|null $date Data no formato ISO
     * @return string Ano
     */
    public static function getYear($date): string
    {
        return self::formatDate($date, 'Y');
    }

    /**
     * Retorna o nome do mês em português
     *
     * @param string|null $date Data no formato ISO
     * @return string Nome do mês
     */
    public static function getMonthName($date): string
    {
        $months = [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro',
        ];

        $month = self::getMonth($date);
        return $months[$month] ?? '';
    }
}
