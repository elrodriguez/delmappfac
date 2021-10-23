<div>
    <div class="row">
        <div class="col-lg-6 col-xl-3 order-lg-1 order-xl-1">
            @livewire('support.helpdesk.ticket-attend-form', ['ticket_id' => $ticket_id])
            @if($ticket->sup_service_area_id == $user->sup_service_area_id)
                @if(in_array($ticket->state, $states_not))
                    @livewire('support.helpdesk.ticket-attend-solution-register', ['ticket_id' => $ticket_id])
                @else
                    @livewire('support.helpdesk.ticket-attend-participants', ['ticket_id' => $ticket_id])
                @endif
            @endif
        </div>
        <div class="col-lg-6 col-xl-3 order-lg-2 order-xl-2">
            @livewire('support.helpdesk.ticket-attend-chat-form', ['ticket_id' => $ticket_id])
            @if($user->sup_service_area_id == $ticket->sup_service_area_id)
                @if(in_array($ticket->state, $states_not))
                    @livewire('support.helpdesk.ticket-attend-resend', ['ticket_id' => $ticket_id])
                @else
                    @livewire('support.helpdesk.ticket-attend-solutions', ['ticket_id' => $ticket_id])
                @endif
            @endif
        </div>
        @if(in_array($ticket->state, $states_not))
            <div class="col-lg-12 col-xl-6 order-lg-3 order-xl-3 mt-3">
                @livewire('support.helpdesk.ticket-attend-suggest-list', ['ticket_id' => $ticket_id])
            </div>
        @endif
    </div>
</div>
