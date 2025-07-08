@php
  if(!empty($kfnTableNamespace)) {
    echo "window.dtx = window.dtx || {};";
    echo "window.dtx[\"%1\$s\"] = function(opts) {";
      echo "window.{$kfnTableNamespace} = window.{$kfnTableNamespace} || {};";
      if(isset($editors)) {
        foreach($editors as $editor) {
          echo "let {$editor?->instance} = window.{$kfnTableNamespace}[\"%1\$s-{$editor?->instance}\"] = new $.fn.dataTable.Editor({$editor?->toJson()});";
          echo $editor?->scripts;
          foreach ((array) $editor->events as $event) {
            echo "{$editor->instance}.on('{$event['event']}', {$event['script']});";
          }
        }
      }
      echo "return window.{$kfnTableNamespace}[\"%1\$s\"] = $(\"#%1\$s\").DataTable($.extend(%2\$s, opts));";
    echo "}";
  }
@endphp
