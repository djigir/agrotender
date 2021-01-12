<?php
    $regions = \App\Models\Regions\Regions::all();
?>

<div class="content body">
    <h5 style="text-align: center; margin-bottom: 3rem;">Загрузить файл с элеваторами</h5>
    <div class="elev-import_table">
        <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder"
               style="border: 1px solid #9CB7C7">
            <tbody>
            <tr>
                <td>
                    <table width="100%" cellspacing="1" cellpadding="1" border="0">
                        <form action="/admin/importelev.php" method="POST" enctype="multipart/form-data"></form>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="mode" value="">
                        <tbody>
                        <tr>
                            <td class="ff" style="padding-left: 1rem;">Формат прайс-листа:</td>
                            <td class="fr" style="padding-bottom: 1rem; padding-left: 2rem;">
                                Колонка 1 - rayon<br>Колонка 2 - name<br>Колонка 3 - orgname<br>Колонка 4 - orgaddr<br>Колонка
                                5 - addr<br>Колонка 6 - phones<br>Колонка 7 - director<br>Колонка 8 - sposhold<br>Колонка
                                9 - usl_podr<br>Колонка 10 - usl_qual<br></td>
                        </tr>
                        <tr>
                            <td class="ff" style="padding-top: 1rem; padding-bottom: 1rem; padding-left: 1rem;">Пропускать первых строк:</td>
                            <td class="fr"><input type="text" size="2" name="newskip" value="0"></td>
                        </tr>
                        <tr>
                            <td class="ff" style="padding-top: 1rem; padding-bottom: 1rem; padding-left: 1rem;">Элеваторы из области:</td>
                            <td class="fr"><select name="oblid">
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select></td>
                        </tr>
                        <tr>
                            <td class="ff" style="padding-top: 1rem; padding-bottom: 1rem; padding-left: 1rem;">Файл (.xls):</td>
                            <td class="fr"><input type="file" name="newprice"></td>
                        </tr>
                        <tr>
                            <td class="fr" colspan="2" align="center" style="padding-top: 1rem;"><input class="btn btn-success" type="submit" value="Загрузить прайс">
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
