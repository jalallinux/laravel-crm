<?php

namespace VentureDrake\LaravelCrm\Services;

use Ramsey\Uuid\Uuid;
use VentureDrake\LaravelCrm\Models\Lead;
use VentureDrake\LaravelCrm\Repositories\LeadRepository;

class LeadService
{
    /**
     * @var LeadRepository
     */
    private $leadRepository;

    /**
     * LeadService constructor.
     * @param LeadRepository $leadRepository
     */
    public function __construct(LeadRepository $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    public function create($request, $person = null, $organisation = null)
    {
        $lead = Lead::create([
            'external_id' => Uuid::uuid4()->toString(),
            'person_id' => $person->id ?? null,
            'person_name' => $request->person_name,
            'organisation_id' => $organisation->id ?? null,
            'organisation_name' => $request->organisation_name,
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'lead_status_id' => 1,
            'user_assigned_id' => $request->user_assigned_id,
        ]);

        $lead->labels()->sync($request->labels ?? []);
        
        return $lead;
    }

    public function update($request, Lead $lead, $person = null, $organisation = null)
    {
        $lead->update([
            'person_id' => $person->id ?? null,
            'person_name' => $request->person_name,
            'organisation_id' => $organisation->id ?? null,
            'organisation_name' => $request->organisation_name,
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'user_assigned_id' => $request->user_assigned_id,
        ]);

        $lead->labels()->sync($request->labels ?? []);
        
        return $lead;
    }
}
