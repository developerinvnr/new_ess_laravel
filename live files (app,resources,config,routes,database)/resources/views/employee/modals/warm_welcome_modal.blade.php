<style>
.joinbox{
    background: #cde2e3;
    font-weight: 600;
    padding: 5px 10px;
    margin: 10px;
    border-radius: 10px;
    box-shadow: 1px 2px 5px #959292;
}
    .warmwelcome-img{
    width: 115px;
    border: 5px solid #c6d9db;
    border-radius: 10px;
    margin-bottom: 15px;
    margin-top: 10px;
    }
    .warm-welcome-modal .modal-content {
    background-image: url('{{ asset('/images/storage/warm-welcome-bg.png') }}');
    background-size: cover;
    background-position: center;
    border-radius: 10px;
}
    .warmwelcomebox{background-color: rgb(98 148 151 / 20%);
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 10px;}
    .endborder{
        border-bottom: 1px solid #ddd;
    }
    .endborder:last-child{
        border-bottom: 0px solid #ddd;
    }

</style>

<div class="modal fade warm-welcome-modal" id="WarmWelcomePopup" tabindex="-1" aria-labelledby="WarmWelcomeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-primary">Warm Welcome {{ now()->format('F Y') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body modal-body-scrollable px-4">
                @foreach ($employees as $emp)
                    <div class="employee-card mb-5 shadow-sm p-4 warmwelcomebox">
                        <div class="text-center mb-4">
                        <img 
                            src="{{ getEmployeeImage($emp['EmployeeID']) }}" 
                            class="warmwelcome-img"
                            alt="employee"
                            onerror="this.onerror=null; this.src='{{ getEmployeeImage($emp['EmployeeID']) }}';"
                        />

                            <h4 class="fw-bold mt-3 mb-1">{{ $emp['name'] }}</h4>
                            <p class="text-muted mb-2">{{ $emp['designation'] }} ( {{ $emp['vertical'] }} ) - {{ $emp['department_name'] }}</p>
                            <div class="mt-2"><span class="joinbox">Joined Our Team on {{ $emp['joining_date'] }}</span></div>
                        </div>
                        <div class="row justify-content-center">
                        <div class="col-md-11 p-3 warmwelcomebox text-center">
                            <p>
                                <strong> {{ $emp['name'] }} </strong> will report to <strong>{{ $emp['reporting_manager'] }}</strong> and will be based in <strong>{{ $emp['location'] }} {{ $emp['state_name'] }}</strong>.
                            </p>

                            @php $q = $emp['qualification']; @endphp
                            @if (filled($q?->Qualification) && filled($q?->Specialization) && filled($q?->Institute))
                                <p>
                                    {{ str_contains($emp['name'], 'Mr.') ? 'He' : 'She' }} holds a <strong>{{ $q->Qualification }}</strong> in <strong>{{ ucfirst($q->Specialization) }}</strong> from <strong>{{ ucwords($q->Institute) }}</strong>.
                                </p>
                            @endif

                            @if ($emp['experience_companies']->isNotEmpty())
                                <p>
                                    {{ str_contains($emp['name'], 'Mr.') ? 'He' : 'She' }} previously worked at
                                    @foreach ($emp['experience_companies'] as $i => $company)
                                        {{ $company }}@if($i + 2 < count($emp['experience_companies'])), @elseif($i + 2 === count($emp['experience_companies'])) & @endif
                                    @endforeach.
                                </p>
                            @endif

                            @if ($emp['family_spouse'] || $emp['family_sons']->isNotEmpty() || $emp['family_daughters']->isNotEmpty() || $emp['family_children']->isNotEmpty())
                                @php
                                    $pronoun = $emp['gender'] === 'M' ? 'him' : 'her';
                                    $possessive = $emp['gender'] === 'M' ? 'his' : 'her';
                                @endphp
                                <p>
                                    We warmly welcome {{ $pronoun }} along with 
                                    @if ($emp['family_spouse'])
                                        {{ $possessive }} spouse <strong>{{ $emp['family_spouse'] }}</strong>
                                    @endif

                                    @if ($emp['family_sons']->isNotEmpty())
                                        {{ $emp['family_spouse'] ? ', ' : '' }}
                                        {{ $emp['family_sons']->count() > 1 ? 'sons' : 'son' }} – {{ $emp['family_sons']->implode(' & ') }}
                                    @endif

                                    @if ($emp['family_daughters']->isNotEmpty())
                                        {{ ($emp['family_spouse'] || $emp['family_sons']->isNotEmpty()) ? ', ' : '' }}
                                        {{ $emp['family_daughters']->count() > 1 ? 'daughters' : 'daughter' }} – {{ $emp['family_daughters']->implode(' & ') }}
                                    @endif

                                    @if ($emp['family_children']->isNotEmpty())
                                        {{ ($emp['family_spouse'] || $emp['family_sons']->isNotEmpty() || $emp['family_daughters']->isNotEmpty()) ? ', ' : '' }}
                                        {{ $emp['family_children']->count() > 1 ? 'children' : 'child' }} – {{ $emp['family_children']->implode(' & ') }}
                                    @endif
                                    .
                                </p>
                            @endif
                        </div>
                        </div>
                        <hr>
                    </div>
                @endforeach
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


