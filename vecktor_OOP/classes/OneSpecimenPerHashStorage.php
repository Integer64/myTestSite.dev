<?php

class OneSpecimenPerHashStorage extends SplObjectStorage {
    public function getHash($o) {
        return uniqid();
    }
}