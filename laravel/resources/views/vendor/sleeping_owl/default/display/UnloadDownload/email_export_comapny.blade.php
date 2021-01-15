<?php
$regions = \App\Models\Regions\Regions::all();
$rubricks_groups = \App\Models\Comp\CompTgroups::all();
?>

{{-- Поставить соотвествующие неймы для области и группы --}}

<table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder" style="margin-top: 5rem;">
    <tbody>
    <tr>
        <td>
            <table width="100%" cellspacing="1" cellpadding="1" border="0">
                <form action="exportmails_comp.php" name="cselfrm" method="POST" target="_blank"></form>
                <input type="hidden" name="action" value="export">
                <input type="hidden" name="action" value="export">
                <tbody>
                <tr>
                    <td class="ff" style="padding-bottom: 4rem;">Раздел:</td>
                    <td class="fr" style="padding-bottom: 4rem;">
                        <select name="topicid0" id="compgroup" onchange="reloadSects(this, 'comptid')">
                            <option value="0">--- Все разделы ---</option>
                            @foreach($rubricks_groups as $tgroup)
                                <option value="{{ $tgroup->id }}">{{ $tgroup->title }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>


                <tr>
                    <td class="ff">Область:</td>
                    <td class="fr">

                        <select name="oblid">
                            <option value="null">--- Все области ---</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="fr" colspan="2" align="center" style="padding-top: 2rem;">
                        <form action="">
                            <input class="btn btn-success" type="submit" value="Экспортировать">
                        </form>
                    </td>
                </tr>

                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

