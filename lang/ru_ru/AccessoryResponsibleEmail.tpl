<p><strong>Уведомление об изменении бронирования</strong></p>

<p>
    {if $ActionType == 'created'}
        Создано новое бронирование с оборудованием, за которое вы отвечаете.
    {elseif $ActionType == 'added'}
        К бронированию добавлено оборудование, за которое вы отвечаете.
    {elseif $ActionType == 'removed'}
        Оборудование, за которое вы отвечаете, было удалено из бронирования.
    {elseif $ActionType == 'updated'}
        Бронирование с вашим оборудованием было обновлено.
    {elseif $ActionType == 'deleted'}
        Бронирование с вашим оборудованием было отменено.
    {/if}
</p>

<p>
    <strong>Переговорка:</strong> {$ResourceName}<br/>
    <strong>Начало:</strong> {$StartDate->Format('d.m.Y H:i')}<br/>
    <strong>Окончание:</strong> {$EndDate->Format('d.m.Y H:i')}<br/>
    {if $ReservationTitle}
        <strong>Тема:</strong> {$ReservationTitle}<br/>
    {/if}
</p>

<p>
    <strong>Оборудование:</strong><br/>
    {foreach from=$Accessories item=accessory}
        — {$accessory->GetName()}<br/>
    {/foreach}
</p>

<p>
    <strong>Организатор:</strong> {$OwnerName}
    {if $OwnerEmail} &lt;{$OwnerEmail}&gt;{/if}
</p>

<p>
    <strong>Номер ссылки:</strong> {$ReferenceNumber}<br/>
    <a href="{$ScriptUrl}?rn={$ReferenceNumber}">Посмотреть бронирование</a>
</p>