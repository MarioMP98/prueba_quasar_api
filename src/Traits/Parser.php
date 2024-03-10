<?php

namespace App\Traits;

trait Parser
{

    protected const DATE_FORMAT = 'd/m/Y H:i:s';

    private function parseUsers($users)
    {
        $arrayCollection = array();

        foreach($users as $item) {
            $arrayCollection[] = $this->parseUser($item);
        }

        return $arrayCollection;
    }

    private function parseUser($item)
    {
        
        return array(
            'id' => $item->getId(),
            'nombre' => $item->getNombre(),
            'email' => $item->getEmail(),
            'password' => $item->getPassword(),
            'created_at' => $this->formatDateTime($item->getCreatedAt()),
            'updated_at' => $this->formatDateTime($item->getUpdatedAt()),
            'deleted_at' =>  $this->formatDateTime($item->getDeletedAt())
        );
    }

    private function parseAnnotations($annotations)
    {
        $arrayCollection = array();

        foreach($annotations as $item) {
            

            $arrayCollection[] = $this->parseAnnotation($item);
        }

        return $arrayCollection;
    }

    private function parseAnnotation($item)
    {
        $user = $item->getUsuario();

        return array(
            'id' => $item->getId(),
            'usuario' => $user ? $user->getNombre() : '',
            'nota' => $item->getNota(),
            'created_at' => $this->formatDateTime($item->getCreatedAt()),
            'updated_at' => $this->formatDateTime($item->getUpdatedAt()),
            'deleted_at' =>  $this->formatDateTime($item->getDeletedAt())
        );
    }

    private function parseCategories($categories): array
    {
        $arrayCollection = array();

        foreach($categories as $item) {

            $arrayCollection[] = $this->parseCategory($item);
        }

        return $arrayCollection;
    }

    private function parseCategory($item) {

        return array(
            'id' => $item->getId(),
            'nombre' => $item->getNombre(),
            'descripcion' => $item->getDescripcion(),
            'created_at' => $this->formatDateTime($item->getCreatedAt()),
            'updated_at' => $this->formatDateTime($item->getUpdatedAt()),
            'deleted_at' =>  $this->formatDateTime($item->getDeletedAt())
        );
    }

    public function formatDateTime($datetime) {

        return $datetime ? $datetime->format($this::DATE_FORMAT) : null;
    }
}
