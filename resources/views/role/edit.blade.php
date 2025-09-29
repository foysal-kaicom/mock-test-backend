@extends('master')

@section('contents')

<div class="bg-white rounded shadow-sm">
    <div class="text-dark p-3 rounded-top" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
        <h3 class="fs-5">Edit Role</h3>
    </div>
    <form action="{{ route('user.roles.update', $role->id) }}" method="POST" class="bg-white p-4 rounded-bottom">
        @csrf
        @method('POST')

        <div class="row">
            <div class="col-md-6 pb-3">
                <label for="" class="pb-2">Enter Role Name <span class="text-danger">*</span></label>
                <input value="{{$role->name}}" required type="text" placeholder="Enter Role Name" name="role_name" class="form-control">
            </div>
        </div>

        <div class="row g-3">
            <!-- Module: Users -->
            @foreach($modules as $module)
            <div class="col-12 col-md-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">{{$module->name}}</h5>
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input selectAll" data-module="permissions">
                        <span>Select All</span>
                    </label>
                    <hr>
                    @foreach($module->Permissions as $permission)
                    <label class="form-check">
                        <input 
                            type="checkbox" 
                            value="{{$permission->id}}" 
                            name="permissions[]" 
                            class="form-check-input perm permissions" 
                            @if($role->permissions->contains('id', $permission->id)) checked @endif>
                        <span>{{$permission->name}}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @hasPermission('user.roles.update')
        <button class="bg-primary rounded text-white mt-3 py-2 px-5 border-0">Submit</button>
        @endHasPermission 
    </form>
</div>

@endsection

@push('js')
<script>
document.querySelectorAll(".selectAll").forEach(selectAllCheckbox => {
    selectAllCheckbox.addEventListener("change", function() {
        let parentModule = this.closest('.card');
        
        let checkboxes = parentModule.querySelectorAll(".permissions");
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
});
</script>
@endpush
