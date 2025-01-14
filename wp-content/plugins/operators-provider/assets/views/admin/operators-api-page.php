<div class='op-admin-page operators-manager-container'>
    <h1>Operators List</h1>
    <div class='operators-table-container'>
        <table class='operators-table'>
            <thead>
                <tr>
                    <?php foreach ($table_headers as $header) : ?>
                        <th><?= $header ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($table_contents)) : ?>
                    <?php foreach ($table_contents as $operator) : ?>
                        <tr>
                            <?php foreach ($operator as $value) : ?>
                                <td>
                                    <?= $value ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>