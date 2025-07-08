<?php

return [
    /*
     * DataTables JavaScript global namespace.
     */

    'namespace' => 'KfnTables',

    /*
     * Default table attributes when generating the table.
     */
    'table' => [
        'class' => 'table table-striped table-hover',
        'id' => 'KfnTableBuilder',
    ],

    /*
     * Html builder script template.
     */
    'script' => 'datatables::script',

    /*
     * Html builder script template for DataTables Editor integration.
     */
    'editor' => 'datatables::editor',
];
