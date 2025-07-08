@php use App\Actions\GetThemeType; @endphp
@foreach($roles as $role)
  <a href="{{ routed('app.user-management.roles.show', $role) }}"
     class="badge fs-7 m-1 {{ app(GetThemeType::class)->handle('badge-light-?', $role->name) }}">
    {{ $role->name }}
  </a>
@endforeach
