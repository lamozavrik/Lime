<div class="box">
    <div class="box-title">
        <p class="title">title</p>
        <div class="box-buttons">
            <a href="#" class="button">Добавить</a>
            <a href="#" class="button">Удалить</a>
        </div>
    </div>
    <div class="box-content">
        <table class="box-table">
            <thead>
                <tr>
                    <th class="checkbox"><input type="checkbox" onchange="$(this).closest('table').find('tbody input[name*=\'check-id\']').prop('checked', this.checked)" /></th>
                    <th class="left">aaa</th>
                    <th class="center">bbb</th>
                    <th class="right">ccc</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="checkbox"><input type="checkbox" name="check-id[]" /></td>
                    <td class="left">aaa</td>
                    <td class="center">bbb</td>
                    <td class="right">ccc</td>
                </tr>
                <tr>
                    <td class="checkbox"><input type="checkbox" name="check-id[]" /></td>
                    <td class="left">aaa</td>
                    <td class="center">bbb</td>
                    <td class="right">ccc</td>
                </tr>
                <tr>
                    <td class="checkbox"><input type="checkbox" name="check-id[]" /></td>
                    <td class="left">aaa</td>
                    <td class="center">bbb</td>
                    <td class="right">ccc</td>
                </tr>
                <tr>
                    <td class="checkbox"><input type="checkbox" name="check-id[]" /></td>
                    <td class="left">aaa</td>
                    <td class="center">bbb</td>
                    <td class="right">ccc</td>
                </tr>
                <tr>
                    <td class="checkbox"><input type="checkbox" name="check-id[]" /></td>
                    <td class="left">aaa</td>
                    <td class="center">bbb</td>
                    <td class="right">ccc</td>
                </tr>
                <tr>
                    <td class="checkbox"><input type="checkbox" name="check-id[]" /></td>
                    <td class="left">aaa</td>
                    <td class="center">bbb</td>
                    <td class="right">ccc</td>
                </tr>
            </tbody>
        </table>
        <?=$this->pagination; ?>
    </div>
</div>