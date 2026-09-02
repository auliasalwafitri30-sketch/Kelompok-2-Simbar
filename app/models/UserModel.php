<?php
/**
 * UserModel.php
 * Model untuk manajemen dan autentikasi pengguna
 */

class UserModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Ambil user berdasarkan username
     */
    public function getByUsername(string $username): ?array
    {
        $query = 'SELECT id_user as id, username, password, role
                  FROM users
                  WHERE username = ?';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result ?: null;
    }

    /**
     * Verifikasi login user
     */
    public function verifyLogin(string $username, string $password)
    {
        $user = $this->getByUsername($username);

        if (!$user) {
            return false;
        }

        // Mendukung password hash maupun plain text
        if (
            $password !== $user['password'] &&
            !password_verify($password, $user['password'])
        ) {
            return false;
        }

        // Jangan return password
        unset($user['password']);

        // Gunakan username sebagai fallback nama lengkap
        $user['nama_lengkap'] = $user['username'];

        return $user;
    }

    /**
     * Ambil user berdasarkan ID
     */
    public function getById(int $id): ?array
    {
        $query = 'SELECT id_user as id, username, role
                  FROM users
                  WHERE id_user = ?';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result ?: null;
    }

    /**
     * Ambil semua user
     */
    public function getAll(): array
    {
        $query = 'SELECT id_user as id, username, role
                  FROM users
                  ORDER BY id_user DESC';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Tambah user baru
     */
    public function create(array $data): bool
    {
        try {
            $query = 'INSERT INTO users
                      (username, password, role)
                      VALUES (?, ?, ?)';

            $stmt = $this->db->prepare($query);

            $hashedPassword = password_hash(
                $data['password'],
                PASSWORD_DEFAULT
            );

            $role = $data['role'] ?? 'staff';

            $stmt->bindParam(
                1,
                $data['username'],
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                2,
                $hashedPassword,
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                3,
                $role,
                PDO::PARAM_STR
            );

            return $stmt->execute();

        } catch (Exception $e) {
            error_log(
                'Error create user: ' . $e->getMessage()
            );

            return false;
        }
    }

    /**
     * Update user
     */
    public function update(int $id, array $data): bool
    {
        try {
            $query = 'UPDATE users SET ';
            $updates = [];
            $params = [];

            if (isset($data['username'])) {
                $updates[] = 'username = ?';
                $params[] = $data['username'];
            }

            if (isset($data['password'])) {
                $updates[] = 'password = ?';
                $params[] = password_hash(
                    $data['password'],
                    PASSWORD_DEFAULT
                );
            }

            if (isset($data['role'])) {
                $updates[] = 'role = ?';
                $params[] = $data['role'];
            }

            if (empty($updates)) {
                return true;
            }

            $query .= implode(', ', $updates);
            $query .= ' WHERE id_user = ?';

            $params[] = $id;

            $stmt = $this->db->prepare($query);

            foreach ($params as $i => $param) {
                $stmt->bindValue(
                    $i + 1,
                    $param,
                    is_int($param)
                        ? PDO::PARAM_INT
                        : PDO::PARAM_STR
                );
            }

            return $stmt->execute();

        } catch (Exception $e) {
            error_log(
                'Error update user: ' . $e->getMessage()
            );

            return false;
        }
    }

    /**
     * Hapus user
     */
    public function delete(int $id): bool
    {
        try {
            $query = 'DELETE FROM users
                      WHERE id_user = ?';

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(
                1,
                $id,
                PDO::PARAM_INT
            );

            return $stmt->execute();

        } catch (Exception $e) {
            error_log(
                'Error delete user: ' . $e->getMessage()
            );

            return false;
        }
    }
}