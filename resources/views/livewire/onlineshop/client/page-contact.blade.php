<div>
    <hr class="soften">
    <div class="well well-small">
        <h1>Visítanos</h1>
        <hr class="soften"/>	
        <div class="row-fluid">
            <div class="span8 relative">
                {!! $configuration->map !!}
                <div class="absoluteBlk">
                    <div class="well wellsmall">
                        <h4>Detalles de contacto</h4>
                        <h5>
                            {{ $configuration->address }}<br/><br/>
                            {{ $configuration->email }}<br/>
                            Tel {{ $configuration->fixed_phone }}<br/>
                            Cel {{ $configuration->mobile_phone }}
                        </h5>
                    </div>
                </div>
            </div>
            
            <div class="span4">
                <h4>Envíanos un correo electrónico</h4>
                <form class="form-horizontal" wire:submit.prevent="save">
                    <fieldset>
                        <div class="control-group">
                            <input wire:model="names" type="text" placeholder="Nombres" class="input-xlarge"/>
                            @error('names')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="control-group">
                            <input wire:model="email" type="text" placeholder="Email" class="input-xlarge"/>
                            @error('email')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="control-group">
                            <input wire:model="phone" type="text" placeholder="Teléfono" class="input-xlarge"/>
                            @error('phone')
                                <div>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="control-group">
                            <input wire:model="subject" type="text" placeholder="Asunto" class="input-xlarge"/>
                            @error('subject')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="control-group">
                            <textarea wire:model="message" rows="3" class="input-xlarge"></textarea>
                            @error('message')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="shopBtn" type="submit" wire:loading.attr="disabled">Enviar</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script defer>
        window.addEventListener('response_contact_email_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
