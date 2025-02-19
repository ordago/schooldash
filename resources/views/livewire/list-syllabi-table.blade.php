<div class="card">
    <div class="card-header">
        <div class="card-title">Syllabi List</div>
    </div>
    <div class="card-body">
        @if (!auth()->user()->hasRole('student'))
            <x-select id="my_class" label="Select a class to see syllabus"  group-class="my-6" name="" wire:model="class">
                @foreach ($classes as $item)
                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                @endforeach
            </x-select>
    
        @endif

        @isset($class)
        <div  wire:loading.remove.delay>
            <livewire:datatable :wire:key="Str::Random(10)" :model="App\Models\MyClass::class"
            :filters="[
                ['name' => 'find' ,'arguments' => [ $class]],
                ['name' => 'syllabi'],
                ['name' => 'where' , 'arguments' =>[ 'semester_id' , auth()->user()->school->semester_id]]
            ]"
            :columns="[
                ['property' => 'name'],
                ['type' => 'dropdown', 'name' => 'actions','links' => [
                    ['href' => 'syllabi.show', 'text' => 'View', 'icon' => 'fas fa-eye'],
                ]],
                ['type' => 'delete', 'name' => 'Delete', 'action' => 'syllabi.destroy',]
            ]"
            />
        </div>
    @endisset
        <x-loading-spinner/>
    </div>
</div>
