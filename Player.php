<?php

class PlayerRepository
{
    /**
     * @var DB;
     */
    protected $db;

    protected $hasher;

    /**
     * PlayerRepository constructor.
     *
     * @param DB $db
     */
    public function __construct(DB $db, Hasher $hasher)
    {
        $this->db = $db;
        $this->hasher = $hasher;
    }

    public function get($id)
    {
        /**
         * SELECT * FROM players WHERE id = {$id}
         */
        // Retrieve result from the database
        $query = $this->db->getConnection()
            ->prepare('SELECT * FROM `players` WHERE id = :id');

        $query->execute([':id' => $id]);

        if (!empty($query) && $query->rowCount() > 0)
        {
            return $query->fetch(PDO::FETCH_OBJ);
        }

        return null;
    }

    /**
     * @param $player
     * @param array $attributes
     * @return stdClass
     */
    public function update($player, array $attributes)
    {
        /**
         * UPDATE players SET {$attributes} WHERE id = {$id}
         */

        $args = [];
        $params = [];
        $updated_player = clone $player;

        foreach ($attributes as $key => $attribute)
        {
            $args[] = $key . ' = :' . $key;
            $params[':' . $key] = $attribute;
            $updated_player->{$key} = $attribute;
        }

        $query = $this->db->getConnection()
            ->prepare('UPDATE players SET ' . implode(', ', $args));

        $query->execute($params);

        if ($query->rowCount() > 0)
        {
            // Return the updated player object
            return $updated_player;
        }

        // No update was made, so return the original player object
        return $player;
    }

    /**
     * Convenience method to update the spin value for a player
     *
     * @param $player
     * @param $credits
     * @return stdClass
     */
    public function updateSpin($player, $credits)
    {
        if (is_numeric($player))
        {
            $player = $this->get($player);
        }

        return $this->update($player, [
            'credits' => $credits,
            'lifetime_spins' => $player->lifetime_spins+1,
        ]);
    }

    /**
     * Convenience method to get a hash of player info
     *
     * @param $player
     * @return bool|string
     */
    public function getHash($player)
    {
        if (is_numeric($player))
        {
            $player = $this->get($player);
        }

        $string_to_hash = $player->id . $player->credits . $player->lifetime_spins;

        return $this->hasher->hash($string_to_hash, $player->salt);
    }

    public function lifetimeAverageReturn($player)
    {
        return round($player->credits/$player->lifetime_spins, 2);
    }
}
