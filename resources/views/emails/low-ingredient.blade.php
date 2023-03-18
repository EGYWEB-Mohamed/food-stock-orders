@component('mail::message')
Your Stock For ( {{ $ingredient->name }} ) Is ( {{ $ingredient->consumed_percentage }} % ) Which Is Low . <br>

Total Stock In Grams : {{ $ingredient->stock_grams }} / ({{ $ingredient->stock_grams / 1000 }} KG) <br>

Based On the Orders Usage In Grams : {{ $ingredient->consumed_grams }} / ({{ $ingredient->consumed_grams / 1000}} KG) <br>

Based On the Orders You Still Have ( {{ $ingredient->name }} ) In Grams : {{ $ingredient->stock_grams - $ingredient->consumed_grams }} / ({{ ($ingredient->stock_grams - $ingredient->consumed_grams) / 1000}} KG)

Thanks,<br>
{{ config('app.name') }}
@endcomponent
