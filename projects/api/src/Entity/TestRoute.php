<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;

/**
 * Classe de test pour vérifier la disponibilité de l'API.
 * Cette ressource n'est pas liée à une table de base de données.
 */
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/test-route',
            description: 'Vérification de la santé de l\'API'
        )
    ]
)]
class TestRoute
{
    public string $message = "La route de test fonctionne parfaitement !";
}