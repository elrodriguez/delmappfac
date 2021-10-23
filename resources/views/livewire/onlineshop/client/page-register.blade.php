<div>
    <ul class="breadcrumb">
		<li><a href="{{ route('onlineshop_public_home') }}">Inicio</a> <span class="divider">/</span></li>
		<li class="active">Registro</li>
    </ul>
    <h3> Registro</h3>	
	<hr class="soft"/>
	<div class="well">
	<form class="form-horizontal" wire:submit.prevent="saveClient">
		<h3>Tus Datos Personales</h3>
		<div class="control-group">
		    <label class="control-label">Tipo de documento <sup>*</sup></label>
            <div class="controls">
                <select class="span3" name="title" wire:model="documet_type_id">
                    <option value="">Seleccionar</option>
                    @foreach($documet_types as $documet_type)
                        <option value="{{ $documet_type->id }}">{{ $documet_type->description }}</option>
                    @endforeach
                </select>
                @error('documet_type_id')<span>{{ $message }}</span>@enderror
		    </div>
		</div>
        <div class="control-group">
			<label class="control-label" for="number">Número de documento <sup>*</sup></label>
			<div class="controls">
			    <input type="text" id="number" placeholder="Número de documento" wire:model="number">
                @error('number')<span>{{ $message }}</span>@enderror
			</div>
		 </div>
         <div class="control-group">
			<label class="control-label" for="address">Dirección <sup>*</sup></label>
			<div class="controls">
			    <input type="text" id="address" placeholder="Dirección" wire:model="address">
                @error('address')<span>{{ $message }}</span>@enderror
			</div>
		 </div>
         <div class="control-group">
		    <label class="control-label">Lugar <sup>*</sup></label>
		    <div class="controls">
                <select class="span2" name="region_id" wire:model="region_id" wire:change="searchProvince">
                    <option value="">Región</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->description }}</option>
                    @endforeach
                </select>
                <select class="span2" name="province_id" wire:model="province_id" wire:change="searchDistrict">
                    <option value="">Provincia</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->description }}</option>
                    @endforeach
                </select>
                <select class="span2" name="district_id" wire:model="district_id">
                    <option value="">Distrito</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->description }}</option>
                    @endforeach
                </select>
                @error('region_id')<span>{{ $message }}</span>@enderror
                @error('province_id')<span>{{ $message }}</span>@enderror
                @error('district_id')<span>{{ $message }}</span>@enderror
            </div>
        </div>
		<div class="control-group">
			<label class="control-label" for="names">Nombres <sup>*</sup></label>
			<div class="controls">
			    <input type="text" id="names" placeholder="Nombres" wire:model="names">
                @error('names')<span>{{ $message }}</span>@enderror
			</div>
		 </div>
		 <div class="control-group">
			<label class="control-label" for="last_name_p">Apellido Paterno <sup>*</sup></label>
			<div class="controls">
			    <input type="text" id="last_name_p" placeholder="Apellido Paterno" wire:model="last_name_p">
                @error('last_name_p')<span>{{ $message }}</span>@enderror
			</div>
		 </div>
         <div class="control-group">
			<label class="control-label" for="last_name_m">Apellido Materno <sup>*</sup></label>
			<div class="controls">
			    <input type="text" id="last_name_m" placeholder="Apellido Materno" wire:model="last_name_m">
                @error('last_name_m')<span>{{ $message }}</span>@enderror
			</div>
		 </div>
		<div class="control-group">
            <label class="control-label" for="email">Email <sup>*</sup></label>
            <div class="controls">
                <input type="text" placeholder="Email" id="email" wire:model="email">
                @error('email')<span>{{ $message }}</span>@enderror
            </div>
        </div>	  
		<div class="control-group">
            <label class="control-label">Password <sup>*</sup></label>
            <div class="controls">
                <input type="password" placeholder="Password" id="password" wire:model="password">
                @error('password')<span>{{ $message }}</span>@enderror
            </div>
        </div>
		<div class="control-group">
		    <label class="control-label">Fecha de nacimiento <sup>*</sup></label>
		    <div class="controls">
                <input onchange="this.dispatchEvent(new InputEvent('input'))" type="text" placeholder="Y/m/d" id="date_of_birth" wire:model="date_of_birth">
                @error('date_of_birth')<span>{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="control-group">
		    <label class="control-label">Género <sup>*</sup></label>
            <div class="controls">
                <select class="span2" name="gender" wire:model="gender">
                    <option value="">Seleccionar</option>
                    <option value="m">Masculino</option>
                    <option value="f">Femenino</option>
                </select>
                @error('gender')<span>{{ $message }}</span>@enderror
		    </div>
		</div>
        <div class="control-group">
            <div class="controls">
                <input type="submit" name="submitAccount" value="Register" class="exclusive shopBtn" wire:target="saveClient" wire:loading.attr="disabled">
            </div>
        </div>
    </form>
</div>
