<?php

namespace ApiExperimental\src\Interfaces\Repositories;

use ApiExperimental\src\Dtos\ProductDto;

/**
 * Interface DbRepositoryInterface
 */
interface DbRepositoryInterface
{
    /**
     * Función que se encargará de ser el contrato para los repositorios de datos.
     * @return DbRepositoryInterface
     */
    public function read($tableName);

    /**
     * Función encargada de registrar un producto a la fuente de datos.
     *
     * @param $tableName
     * @return int | boolean
     */
    public function create($productDto);

    /**
     * Función que se encarga de devolver el registro asociado al id
     *
     * @param $id
     * @param $tableName
     * @return null | array
     */
    public function readOne($id, $tableName);

    /**
     * Función encargada de actualizar un registro
     * utilizando el id como método univoco de identificación
     * modificando los campos contenidos en el productDto $dto
     *
     * @param int $id
     * @param string $tableName
     * @param ProductDto $dto
     * @return boolean
     */
    public function update($id, $tableName, $dto);
}
