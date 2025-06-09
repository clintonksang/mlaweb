<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProspectController extends Controller
{
    /**
     * Display a listing of prospects.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Prospect::query();

            // Apply search filter
            if ($request->has('search') && $request->search) {
                $query->search($request->search);
            }

            // Apply status filter
            if ($request->has('status') && $request->status) {
                $query->status($request->status);
            }

            // Apply KYC status filter
            if ($request->has('kyc_status') && $request->kyc_status) {
                $query->kycStatus($request->kyc_status);
            }

            // Pagination
            $perPage = $request->get('limit', 20);
            $page = $request->get('page', 1);
            
            $prospects = $query->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'status' => 'success',
                'message' => 'Prospects retrieved successfully',
                'data' => [
                    'prospects' => $prospects->items(),
                    'pagination' => [
                        'current_page' => $prospects->currentPage(),
                        'total_pages' => $prospects->lastPage(),
                        'total_records' => $prospects->total(),
                        'per_page' => $prospects->perPage(),
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve prospects',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created prospect.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'primary_phone' => 'required|string|max:20|unique:prospects,primary_phone',
                'email_official' => 'nullable|email|max:255',
                'email_personal' => 'nullable|email|max:255',
                'id_passport' => 'required|string|max:50|unique:prospects,id_passport',
                'kra_pin' => 'nullable|string|max:20',
                'gender' => 'nullable|in:Male,Female,Other',
                'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
                'dob' => 'nullable|date|before:today',
                'education' => 'nullable|string|max:255',
                'postal_address' => 'nullable|string|max:500',
                'bank_name' => 'nullable|string|max:255',
                'bank_branch' => 'nullable|string|max:255',
                'account_title' => 'nullable|string|max:255',
                'account_number' => 'nullable|string|max:50',
                'county' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'sub_location' => 'nullable|string|max:255',
                'building_name' => 'nullable|string|max:255',
                'house_no' => 'nullable|string|max:50',
                'residence_ownership' => 'nullable|string|max:255',
                'residence_landmark' => 'nullable|string|max:500',
                'nok_name' => 'nullable|string|max:255',
                'nok_relationship' => 'nullable|string|max:255',
                'nok_id' => 'nullable|string|max:50',
                'nok_phone' => 'nullable|string|max:20',
                'nok_address' => 'nullable|string|max:500',
                'referee1_name' => 'nullable|string|max:255',
                'referee1_phone' => 'nullable|string|max:20',
                'referee1_relationship' => 'nullable|string|max:255',
                'referee2_name' => 'nullable|string|max:255',
                'referee2_phone' => 'nullable|string|max:20',
                'referee2_relationship' => 'nullable|string|max:255',
                'source' => 'nullable|string|max:255',
                'applicant_signature' => 'nullable|string|max:255',
                'terms_signature' => 'nullable|string|max:255',
                'id_passport_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
                'kra_pin_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Handle file uploads
            $idPassportPath = null;
            $kraPinPath = null;

            if ($request->hasFile('id_passport_file')) {
                $idPassportPath = $this->uploadFile($request->file('id_passport_file'), 'prospects/id_documents');
            }

            if ($request->hasFile('kra_pin_file')) {
                $kraPinPath = $this->uploadFile($request->file('kra_pin_file'), 'prospects/kra_documents');
            }

            // Create prospect
            $prospectData = $request->except(['id_passport_file', 'kra_pin_file']);
            $prospectData['id_passport_file_path'] = $idPassportPath;
            $prospectData['kra_pin_file_path'] = $kraPinPath;
            $prospectData['kyc_status'] = ($idPassportPath && $kraPinPath) ? true : false;

            $prospect = Prospect::create($prospectData);

            return response()->json([
                'status' => 'success',
                'message' => 'Prospect created successfully',
                'data' => [
                    'id' => $prospect->uuid,
                    'name' => $prospect->name,
                    'phone' => $prospect->primary_phone,
                    'email' => $prospect->email_official,
                    'id_number' => $prospect->id_passport,
                    'kyc_status' => $prospect->kyc_status,
                    'created_at' => $prospect->created_at->toISOString(),
                    'files' => [
                        'id_passport_url' => $prospect->id_passport_url,
                        'kra_pin_url' => $prospect->kra_pin_url,
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create prospect',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified prospect.
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        try {
            $prospect = Prospect::where('uuid', $uuid)->first();

            if (!$prospect) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Prospect not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Prospect retrieved successfully',
                'data' => [
                    'id' => $prospect->uuid,
                    'personal_info' => [
                        'name' => $prospect->name,
                        'phone' => $prospect->primary_phone,
                        'email_official' => $prospect->email_official,
                        'email_personal' => $prospect->email_personal,
                        'id_number' => $prospect->id_passport,
                        'kra_pin' => $prospect->kra_pin,
                        'gender' => $prospect->gender,
                        'marital_status' => $prospect->marital_status,
                        'dob' => $prospect->dob?->format('Y-m-d'),
                        'education' => $prospect->education,
                    ],
                    'contact_info' => [
                        'postal_address' => $prospect->postal_address,
                    ],
                    'bank_info' => [
                        'bank_name' => $prospect->bank_name,
                        'bank_branch' => $prospect->bank_branch,
                        'account_title' => $prospect->account_title,
                        'account_number' => $prospect->account_number,
                    ],
                    'address_info' => [
                        'county' => $prospect->county,
                        'district' => $prospect->district,
                        'location' => $prospect->location,
                        'sub_location' => $prospect->sub_location,
                        'building_name' => $prospect->building_name,
                        'house_no' => $prospect->house_no,
                        'residence_ownership' => $prospect->residence_ownership,
                        'landmark' => $prospect->residence_landmark,
                    ],
                    'next_of_kin' => [
                        'name' => $prospect->nok_name,
                        'relationship' => $prospect->nok_relationship,
                        'id_number' => $prospect->nok_id,
                        'phone' => $prospect->nok_phone,
                        'address' => $prospect->nok_address,
                    ],
                    'referees' => [
                        [
                            'name' => $prospect->referee1_name,
                            'phone' => $prospect->referee1_phone,
                            'relationship' => $prospect->referee1_relationship,
                        ],
                        [
                            'name' => $prospect->referee2_name,
                            'phone' => $prospect->referee2_phone,
                            'relationship' => $prospect->referee2_relationship,
                        ]
                    ],
                    'files' => [
                        'id_passport_url' => $prospect->id_passport_url,
                        'kra_pin_url' => $prospect->kra_pin_url,
                    ],
                    'kyc_status' => $prospect->kyc_status,
                    'status' => $prospect->status,
                    'created_at' => $prospect->created_at->toISOString(),
                    'updated_at' => $prospect->updated_at->toISOString(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve prospect',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified prospect.
     *
     * @param Request $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        try {
            $prospect = Prospect::where('uuid', $uuid)->first();

            if (!$prospect) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Prospect not found'
                ], 404);
            }

            // Validation rules (similar to store but with unique rules excluding current record)
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'primary_phone' => 'required|string|max:20|unique:prospects,primary_phone,' . $prospect->id,
                'email_official' => 'nullable|email|max:255',
                'email_personal' => 'nullable|email|max:255',
                'id_passport' => 'required|string|max:50|unique:prospects,id_passport,' . $prospect->id,
                'kra_pin' => 'nullable|string|max:20',
                'gender' => 'nullable|in:Male,Female,Other',
                'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
                'dob' => 'nullable|date|before:today',
                'education' => 'nullable|string|max:255',
                'postal_address' => 'nullable|string|max:500',
                'bank_name' => 'nullable|string|max:255',
                'bank_branch' => 'nullable|string|max:255',
                'account_title' => 'nullable|string|max:255',
                'account_number' => 'nullable|string|max:50',
                'county' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'sub_location' => 'nullable|string|max:255',
                'building_name' => 'nullable|string|max:255',
                'house_no' => 'nullable|string|max:50',
                'residence_ownership' => 'nullable|string|max:255',
                'residence_landmark' => 'nullable|string|max:500',
                'nok_name' => 'nullable|string|max:255',
                'nok_relationship' => 'nullable|string|max:255',
                'nok_id' => 'nullable|string|max:50',
                'nok_phone' => 'nullable|string|max:20',
                'nok_address' => 'nullable|string|max:500',
                'referee1_name' => 'nullable|string|max:255',
                'referee1_phone' => 'nullable|string|max:20',
                'referee1_relationship' => 'nullable|string|max:255',
                'referee2_name' => 'nullable|string|max:255',
                'referee2_phone' => 'nullable|string|max:20',
                'referee2_relationship' => 'nullable|string|max:255',
                'source' => 'nullable|string|max:255',
                'applicant_signature' => 'nullable|string|max:255',
                'terms_signature' => 'nullable|string|max:255',
                'id_passport_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'kra_pin_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Handle file uploads
            $updateData = $request->except(['id_passport_file', 'kra_pin_file']);

            if ($request->hasFile('id_passport_file')) {
                // Delete old file if exists
                if ($prospect->id_passport_file_path) {
                    Storage::disk('public')->delete($prospect->id_passport_file_path);
                }
                $updateData['id_passport_file_path'] = $this->uploadFile($request->file('id_passport_file'), 'prospects/id_documents');
            }

            if ($request->hasFile('kra_pin_file')) {
                // Delete old file if exists
                if ($prospect->kra_pin_file_path) {
                    Storage::disk('public')->delete($prospect->kra_pin_file_path);
                }
                $updateData['kra_pin_file_path'] = $this->uploadFile($request->file('kra_pin_file'), 'prospects/kra_documents');
            }

            // Update KYC status
            $updateData['kyc_status'] = (
                ($prospect->id_passport_file_path || isset($updateData['id_passport_file_path'])) && 
                ($prospect->kra_pin_file_path || isset($updateData['kra_pin_file_path']))
            );

            $prospect->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Prospect updated successfully',
                'data' => [
                    'id' => $prospect->uuid,
                    'name' => $prospect->name,
                    'phone' => $prospect->primary_phone,
                    'updated_at' => $prospect->updated_at->toISOString(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update prospect',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified prospect.
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function destroy(string $uuid): JsonResponse
    {
        try {
            $prospect = Prospect::where('uuid', $uuid)->first();

            if (!$prospect) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Prospect not found'
                ], 404);
            }

            // Delete associated files
            if ($prospect->id_passport_file_path) {
                Storage::disk('public')->delete($prospect->id_passport_file_path);
            }
            if ($prospect->kra_pin_file_path) {
                Storage::disk('public')->delete($prospect->kra_pin_file_path);
            }

            $prospect->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Prospect deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete prospect',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload file to storage
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @return string
     */
    private function uploadFile($file, $path): string
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }
}
