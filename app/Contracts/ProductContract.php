<?php

namespace App\Contracts;

interface ProductContract
{
    public function getAll();

    public function create(array $data);

    public function edit($id);

    public function update(array $data, $id);

    public function delete($id);
}
