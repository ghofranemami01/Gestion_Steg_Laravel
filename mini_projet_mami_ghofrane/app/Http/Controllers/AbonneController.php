<?php

namespace App\Http\Controllers;

use App\Models\Abonne;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AbonneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Abonne::query();

            // Recherche par terme
            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            // Tri
            $sortBy = $request->get('sort_by', 'nom');
            $sortDirection = $request->get('sort_direction', 'asc');

            if (in_array($sortBy, ['nom', 'prenom', 'reference', 'date_abonnement', 'created_at'])) {
                $query->orderBy($sortBy, $sortDirection);
            }

            // Pagination
            $perPage = $request->get('per_page', 15);
            $abonnes = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $abonnes->items(),
                'pagination' => [
                    'current_page' => $abonnes->currentPage(),
                    'last_page' => $abonnes->lastPage(),
                    'per_page' => $abonnes->perPage(),
                    'total' => $abonnes->total(),
                    'from' => $abonnes->firstItem(),
                    'to' => $abonnes->lastItem()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des abonnés',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'reference' => 'required|string|max:50|unique:abonnes,reference',
                'num_cin' => 'required|string|max:20|unique:abonnes,num_cin',
                'nom' => 'required|string|max:100',
                'prenom' => 'required|string|max:100',
                'date_abonnement' => 'required|date',
                'num_compteur_elec' => 'required|string|max:50|unique:abonnes,num_compteur_elec',
                'num_compteur_gaz' => 'required|string|max:50|unique:abonnes,num_compteur_gaz',
                'adresse' => 'required|string',
                'tel' => 'required|string|max:20',
                'email' => 'required|email|max:255|unique:abonnes,email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Données invalides',
                    'errors' => $validator->errors()
                ], 422);
            }

            $abonne = Abonne::create($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Abonné créé avec succès',
                'data' => $abonne
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'abonné',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $abonne = Abonne::find($id);

            if (!$abonne) {
                return response()->json([
                    'success' => false,
                    'message' => 'Abonné non trouvé'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $abonne
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de l\'abonné',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $abonne = Abonne::find($id);

            if (!$abonne) {
                return response()->json([
                    'success' => false,
                    'message' => 'Abonné non trouvé'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'reference' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('abonnes', 'reference')->ignore($id)
                ],
                'num_cin' => [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('abonnes', 'num_cin')->ignore($id)
                ],
                'nom' => 'required|string|max:100',
                'prenom' => 'required|string|max:100',
                'date_abonnement' => 'required|date',
                'num_compteur_elec' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('abonnes', 'num_compteur_elec')->ignore($id)
                ],
                'num_compteur_gaz' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('abonnes', 'num_compteur_gaz')->ignore($id)
                ],
                'adresse' => 'required|string',
                'tel' => 'required|string|max:20',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('abonnes', 'email')->ignore($id)
                ]
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Données invalides',
                    'errors' => $validator->errors()
                ], 422);
            }

            $abonne->update($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Abonné modifié avec succès',
                'data' => $abonne->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification de l\'abonné',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $abonne = Abonne::find($id);

            if (!$abonne) {
                return response()->json([
                    'success' => false,
                    'message' => 'Abonné non trouvé'
                ], 404);
            }

            $abonne->delete();

            return response()->json([
                'success' => true,
                'message' => 'Abonné supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'abonné',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Recherche avancée d'abonnés
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = Abonne::query();

            // Recherche par nom
            if ($request->has('nom') && !empty($request->nom)) {
                $query->where('nom', 'like', '%' . $request->nom . '%');
            }

            // Recherche par prénom
            if ($request->has('prenom') && !empty($request->prenom)) {
                $query->where('prenom', 'like', '%' . $request->prenom . '%');
            }

            // Recherche par référence
            if ($request->has('reference') && !empty($request->reference)) {
                $query->where('reference', 'like', '%' . $request->reference . '%');
            }

            // Recherche par CIN
            if ($request->has('num_cin') && !empty($request->num_cin)) {
                $query->where('num_cin', 'like', '%' . $request->num_cin . '%');
            }

            // Recherche par email
            if ($request->has('email') && !empty($request->email)) {
                $query->where('email', 'like', '%' . $request->email . '%');
            }

            // Recherche par téléphone
            if ($request->has('tel') && !empty($request->tel)) {
                $query->where('tel', 'like', '%' . $request->tel . '%');
            }

            // Recherche par période d'abonnement
            if ($request->has('date_debut') && !empty($request->date_debut)) {
                $query->whereDate('date_abonnement', '>=', $request->date_debut);
            }

            if ($request->has('date_fin') && !empty($request->date_fin)) {
                $query->whereDate('date_abonnement', '<=', $request->date_fin);
            }

            $abonnes = $query->orderBy('nom', 'asc')->get();

            return response()->json([
                'success' => true,
                'data' => $abonnes,
                'count' => $abonnes->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Statistiques des abonnés
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = [
                'total_abonnes' => Abonne::count(),
                'abonnes_ce_mois' => Abonne::whereMonth('created_at', now()->month)
                                          ->whereYear('created_at', now()->year)
                                          ->count(),
                'abonnes_par_mois' => Abonne::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
                                          ->whereYear('created_at', now()->year)
                                          ->groupByRaw('MONTH(created_at)')
                                          ->orderBy('mois')
                                          ->get(),
                'dernier_abonne' => Abonne::latest()->first()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du calcul des statistiques',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ========================================
    // MÉTHODES POUR LES VUES WEB TRADITIONNELLES
    // ========================================

    /**
     * Afficher la liste des abonnés (vue web)
     */
    public function webIndex()
    {
        $abonnes = Abonne::orderBy('nom', 'asc')->paginate(10);
        return view('abonnes.index', compact('abonnes'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function webCreate()
    {
        return view('abonnes.create');
    }

    /**
     * Enregistrer un nouvel abonné
     */
    public function webStore(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'reference' => 'required|string|max:50|unique:abonnes,reference',
                'num_cin' => 'required|string|max:20|unique:abonnes,num_cin',
                'nom' => 'required|string|max:100',
                'prenom' => 'required|string|max:100',
                'date_abonnement' => 'required|date',
                'num_compteur_elec' => 'required|string|max:50|unique:abonnes,num_compteur_elec',
                'num_compteur_gaz' => 'required|string|max:50|unique:abonnes,num_compteur_gaz',
                'adresse' => 'required|string',
                'tel' => 'required|string|max:20',
                'email' => 'required|email|max:255|unique:abonnes,email'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                               ->withErrors($validator)
                               ->withInput();
            }

            Abonne::create($validator->validated());

            return redirect()->route('abonnes.index')
                           ->with('success', 'Abonné créé avec succès');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Erreur lors de la création: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Afficher les détails d'un abonné
     */
    public function webShow(string $id)
    {
        try {
            $abonne = Abonne::findOrFail($id);
            return view('abonnes.show', compact('abonne'));
        } catch (\Exception $e) {
            return redirect()->route('abonnes.index')
                           ->with('error', 'Abonné non trouvé');
        }
    }

    /**
     * Afficher le formulaire de modification
     */
    public function webEdit(string $id)
    {
        try {
            $abonne = Abonne::findOrFail($id);
            return view('abonnes.edit', compact('abonne'));
        } catch (\Exception $e) {
            return redirect()->route('abonnes.index')
                           ->with('error', 'Abonné non trouvé');
        }
    }

    /**
     * Modifier un abonné
     */
    public function webUpdate(Request $request, string $id)
    {
        try {
            $abonne = Abonne::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'reference' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('abonnes', 'reference')->ignore($id)
                ],
                'num_cin' => [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('abonnes', 'num_cin')->ignore($id)
                ],
                'nom' => 'required|string|max:100',
                'prenom' => 'required|string|max:100',
                'date_abonnement' => 'required|date',
                'num_compteur_elec' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('abonnes', 'num_compteur_elec')->ignore($id)
                ],
                'num_compteur_gaz' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('abonnes', 'num_compteur_gaz')->ignore($id)
                ],
                'adresse' => 'required|string',
                'tel' => 'required|string|max:20',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('abonnes', 'email')->ignore($id)
                ]
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                               ->withErrors($validator)
                               ->withInput();
            }

            $abonne->update($validator->validated());

            return redirect()->route('abonnes.index')
                           ->with('success', 'Abonné modifié avec succès');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Erreur lors de la modification: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Supprimer un abonné
     */
    public function webDestroy(string $id)
    {
        try {
            $abonne = Abonne::findOrFail($id);
            $abonne->delete();

            return redirect()->route('abonnes.index')
                           ->with('success', 'Abonné supprimé avec succès');

        } catch (\Exception $e) {
            return redirect()->route('abonnes.index')
                           ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
