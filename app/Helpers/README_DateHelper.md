# DateHelper - Classe Auxiliar de Formatação de Datas

## Descrição
Classe estática para formatação de datas em diversos formatos, especialmente para o formato brasileiro.

## Localização
`/app/Helpers/DateHelper.php`

## Métodos Disponíveis

### formatDate($date, $format = 'd-m-Y')
Formata uma data para o formato especificado (padrão: dd-mm-yyyy)

**Parâmetros:**
- `$date` (string|null): Data no formato ISO ou qualquer formato válido
- `$format` (string): Formato de saída (padrão: 'd-m-Y')

**Retorno:** String com a data formatada

**Exemplo:**
```php
use App\Helpers\DateHelper;

$dataFormatada = DateHelper::formatDate('2024-01-15'); 
// Retorna: "15-01-2024"

$dataFormatada = DateHelper::formatDate('2024-01-15', 'Y/m/d');
// Retorna: "2024/01/15"
```

### formatBrazilianDate($date)
Formata uma data para o formato brasileiro (dd/mm/yyyy)

**Exemplo:**
```php
$dataFormatada = DateHelper::formatBrazilianDate('2024-01-15');
// Retorna: "15/01/2024"
```

### formatBrazilianDateTime($datetime)
Formata uma data e hora para o formato brasileiro

**Exemplo:**
```php
$dataHoraFormatada = DateHelper::formatBrazilianDateTime('2024-01-15 14:30:00');
// Retorna: "15/01/2024 14:30:00"
```

### getDay($date)
Retorna apenas o dia da data

**Exemplo:**
```php
$dia = DateHelper::getDay('2024-01-15');
// Retorna: "15"
```

### getMonth($date)
Retorna apenas o mês da data

**Exemplo:**
```php
$mes = DateHelper::getMonth('2024-01-15');
// Retorna: "01"
```

### getYear($date)
Retorna apenas o ano da data

**Exemplo:**
```php
$ano = DateHelper::getYear('2024-01-15');
// Retorna: "2024"
```

### getMonthName($date)
Retorna o nome do mês em português

**Exemplo:**
```php
$nomeMes = DateHelper::getMonthName('2024-01-15');
// Retorna: "Janeiro"
```

## Uso no Controller

### HomeController.php
```php
use App\Helpers\DateHelper;

public function show(Request $request): View
{
    $materiasHome = $this->homeApiService->fetchMateriasHome();
    
    // Formata as datas das matérias para dd-mm-yyyy
    foreach ($materiasHome as &$materia) {
        if (isset($materia['created_at'])) {
            $materia['created_at_formatted'] = DateHelper::formatDate($materia['created_at']);
        }
        if (isset($materia['data_publicacao'])) {
            $materia['data_publicacao_formatted'] = DateHelper::formatDate($materia['data_publicacao']);
        }
    }
    
    return view('pages.home', ['materiasHome' => $materiasHome]);
}
```

## Uso na View (Blade)

### home.blade.php
```php
<!-- Exibir data formatada -->
<p><i class="far fa-clock"></i> {{ $materia['data_publicacao_formatted'] ?? '' }}</p>

<!-- Ou usar diretamente na view -->
<p><i class="far fa-clock"></i> {{ \App\Helpers\DateHelper::formatDate($materia['created_at']) }}</p>

<!-- Exibir com nome do mês -->
<p>Publicado em: {{ \App\Helpers\DateHelper::getMonthName($materia['created_at']) }}</p>
```

## Exemplo Completo na Aplicação

No arquivo `/resources/views/pages/home.blade.php`:

```blade
<div class="carousel-caption d-none d-md-block">
    <a class="cn-title" href="/{{$materiasHome[0]['vchr_LinkTitulo']}}">
        <h5>{{$materiasHome[0]['vchr_Titulo']}}</h5>
        <p>
            <i class="far fa-clock"></i> 
            {{$materiasHome[0]['data_publicacao_formatted'] ?? $materiasHome[0]['created_at_formatted'] ?? ''}}
        </p>
    </a>
</div>
```

## Observações

- A classe retorna string vazia se a data for inválida ou nula
- Todas as exceções são tratadas internamente
- A classe usa `DateTime` do PHP para garantir compatibilidade com diversos formatos de entrada
