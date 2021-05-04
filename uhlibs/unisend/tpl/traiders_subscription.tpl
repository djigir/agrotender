<table style="width: 100%; font: 14px/14px Tahoma;">
    <tr><td colspan="2" style="font: bold 24px/24px Tahoma; color: #000000;">Здравствуйте, {FULL_NAME}</td></tr>
    <tr><td colspan="2" style="font: 14px/24px Tahoma; padding-top: 30px;">
        <b>{DATE_TIME}</b>
    </td></tr>

    {ARR_TPL_ITEMS_LIST}
    <tr><td colspan="2" style="padding-top: 40px;">Список трейдеров изменивших цену на <b>{ITEM_NAME}:</b></td></tr>
    <tr width="100%">
        <td style="font: 18px/18px"><b>{TRAIDERS_LIST}</b></td>
        <td style="text-align: right; padding: 12px 0;"><a href="{URL_TRAIDER}" style="text-decoration: none;  color: #ffffff; "><div style="display: table-cell; text-align: center; vertical-align: middle; width: 160px; padding: 10px 20px; font: bold 14px/14px Tahoma; background: #008dff; border-radius: 3px;">ОЗНАКОМИТЬСЯ</div></a></td>
    </tr>
    <tr style="height: 1px;"><td colspan="2" style="background: #bdbcbc;"></td></tr>
    {/ARR_TPL_ITEMS_LIST}
</table>