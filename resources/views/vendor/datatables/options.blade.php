@php
if(!empty($kfnTableNamespace)) {
  echo "window.{$kfnTableNamespace} = window.{$kfnTableNamespace} || {};";
  echo "window.{$kfnTableNamespace}.options = %2\$s;";
  echo "window.{$kfnTableNamespace}.editors = [];";
  foreach($editors ?? [] as $editor) {
    echo "window.{$kfnTableNamespace}.editors[\"{$editor?->instance}\"] = {$editor?->toJson()}";
  }
}
@endphp
