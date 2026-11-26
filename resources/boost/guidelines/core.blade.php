## Lara Zeus Dynamic Dashboard (`lara-zeus/dynamic-dashboard`)

Lara Zeus Dynamic Dashboard lets admins and users build customizable multi-column widget layouts for Filament dashboards and frontend landing pages.

### Key Classes & Contracts
- Plugin: `LaraZeus\DynamicDashboard\DynamicDashboardPlugin` (ID: `zeus-dynamic-dashboard`)
- Service provider: `LaraZeus\DynamicDashboard\DynamicDashboardServiceProvider` (`$name = 'zeus-dynamic-dashboard'`)
- Facade: `LaraZeus\DynamicDashboard\Facades\DynamicDashboard` (alias `DynamicDashboard`)
- Filament Resource & Model: `LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource`, `LaraZeus\DynamicDashboard\Models\Layout`, `LaraZeus\DynamicDashboard\Enums\Columns`
- Filament Pages: `LaraZeus\DynamicDashboard\Filament\Pages\DynamicDashboard` (extends `Dashboard`), `LaraZeus\DynamicDashboard\Filament\Pages\DynamicDashboardPage` (extends `Page`), trait `LaraZeus\DynamicDashboard\Filament\Pages\Concerns\Dash`
- Livewire frontend component: `LaraZeus\DynamicDashboard\Livewire\Layouts` (registered as `landing`, route `landing-page`)
- Widget contract & trait: `LaraZeus\DynamicDashboard\Contracts\Widget`, `LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets`

### Rules & Anti-Patterns
- Custom widgets must implement `LaraZeus\DynamicDashboard\Contracts\Widget` (not a `Widgets\Widget` namespace) and typically use `LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets`.
- Place app custom widgets in `App\Zeus\Widgets` (or scaffold via `php artisan make:zeus-widget {name}`) so `DynamicDashboard::available()` discovers them automatically.
- On `DynamicDashboardPlugin::make()`, use `->setDefaultLayout('...')` and `->hideResources([LayoutResource::class])` (there is no `->defaultLayout()` or `->hideLayoutResource()` method on the plugin class).
