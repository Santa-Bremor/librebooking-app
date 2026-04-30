<p><strong>Accessory Setup Notification</strong></p>

<p>
{if $ActionType == 'created'}
A new reservation has been created that requires your assistance with equipment setup.
{elseif $ActionType == 'updated'}
A reservation has been updated that requires your assistance with equipment setup.
{elseif $ActionType == 'deleted'}
A reservation has been cancelled that previously required equipment setup.
{/if}
</p>

<p>
<strong>Room:</strong> {$ResourceName}<br/>
<strong>Start:</strong> {$StartDate->Format('m/d/Y H:i')}<br/>
<strong>End:</strong> {$EndDate->Format('m/d/Y H:i')}<br/>
{if $ReservationTitle}
<strong>Title:</strong> {$ReservationTitle}<br/>
{/if}
</p>

<p>
<strong>Equipment requiring setup:</strong><br/>
{foreach from=$Accessories item=accessory}
&mdash; {$accessory->GetName()}<br/>
{/foreach}
</p>

<p>
<strong>Organizer:</strong> {$OwnerName}
{if $OwnerEmail} &lt;{$OwnerEmail}&gt;{/if}
</p>

<p>
<strong>Reference Number:</strong> {$ReferenceNumber}<br/>
<a href="{$ScriptUrl}?rn={$ReferenceNumber}">View Reservation</a>
</p>
