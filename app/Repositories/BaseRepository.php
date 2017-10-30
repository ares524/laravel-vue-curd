<?php
/**
 * Created by PhpStorm.
 * User: oleg-m
 * Date: 27.10.17
 * Time: 17:32
 */

namespace App\Repositories;


interface BaseRepository
{
    /**
     * Get all
     *
     * @return mixed
     */
    function getAll();
    /**
     * Get by id
     *
     * @param int $id
     * @return mixed
     */
    function getById(int $id);
    /**
     * Create new
     *
     * @param array $attributes
     * @return mixed
     */
    function create(array $attributes);
    /**
     * Update
     *
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    function update(int $id, array $attributes);
    /**
     * Destroy
     *
     * @param int $id
     * @return mixed
     */
    function delete(int $id);
}