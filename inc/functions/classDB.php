<?php

class DB
{
    // Inicializando la variable conexion
    private $conn;

    public function __construct($host, $user, $password, $database)
    {
        $this->conn = new mysqli($host, $user, $password, $database);
        $this->conn->set_charset("utf8");

        if ($this->conn->connect_error) {
            $error = $this->conn->connect_error;
            echo $error;
        }
    }

    // Consulta Create
    public function query_modify($query, $type_value, $bind_parametros)
    {

        try {
            $stmt = $this->conn->prepare($query);
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type_value), $bind_parametros));
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_insertado' => $stmt->insert_id
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $this->conn->close();
        } catch (Exception $e) {
            $respuesta = array(
                'respuesta' => $e->getMessage()
            );
        }
        return $respuesta;
    }

    public function query_modify_data($query, $type_value, $bind_parametros)
    {

        try {
            $stmt = $this->conn->prepare($query);
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type_value), $bind_parametros));
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'correcto'
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $this->conn->close();
        } catch (Exception $e) {
            $respuesta = array(
                'respuesta' => $e->getMessage()
            );
        }
        return $respuesta;
    }

    // Consulta para loguear el usuario
    public function query_login($query, $type_value, $bind_parametros, $password)
    {
        try {
            $stmt = $this->conn->prepare($query);
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type_value), $bind_parametros));
            $stmt->execute();
            // Loguear al usuario - VALORES SETEADOS MANUALMENTE
            $stmt->bind_result($id_usuario, $nombre_usuario, $password_usuario);
            $stmt->fetch();
            // Verifica si el usuario existe
            if ($nombre_usuario) {
                // Verifica si el password coincide con el de la base de datos
                if (password_verify($password, $password_usuario)) {
                    // Iniciar sesion
                    $_SESSION['nombre'] = $nombre_usuario;
                    $_SESSION['id'] = $id_usuario;
                    $_SESSION['login'] = true;
                    // Login correcto
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'nombre' => $nombre_usuario
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'Password incorrecto'
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'Usuario no existe'
                );
            }


            $stmt->close();
            $this->conn->close();
        } catch (Exception $e) {
            $respuesta = array(
                'respuesta' => $e->getMessage()
            );
        }

        return $respuesta;
    }

    public function query_consult($query)
    {
        try {
            $stmt = $this->conn->query($query);
            return $stmt;
        } catch (Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
    }
}
