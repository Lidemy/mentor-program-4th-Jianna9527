<?php
require_once('conn.php');
require_once('utils.php');

session_start();
check_login_status();
$username = $_SESSION['username'];

if (!check_permission($username, 1)) {
    header('location: index.php');
    exit();
}

$query_string = 'SELECT nickname, username, role FROM jianna_w11_users ORDER BY FIELD(role, 1, 99, 0)';
$stmt = $conn->prepare($query_string);
if (!$stmt->execute()) {
    die($stmt->error);
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>權限管理</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <main class="input-form__wrapper member-form__width">
            <form method="POST" action="handle_member.php">
                <div class="login_area">
                    <input type="button" value="回留言板" onclick="location.href='index.php'">
                </div>
                <h1>會員權限管理</h1>
                <div class="member-table__wrapper">
                    <table>
                        <tr>
                            <th>暱稱</th>
                            <th>帳號</th>
                            <th>權限</th>
                            <th>編輯</th>
                        </tr>
                        <?php
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                            switch (escape($row['role'])) {
                                case '0':
                                    $role = '停權';
                                    break;
                                case '1':
                                    $role = '管理員';
                                    break;
                                case '99':
                                    $role = '一般成員';
                                    break;
                                default:
                                    $role = '無權限資料';
                            }
                            echo '<tr>
                            <td>' . escape($row['nickname']) . '</td>
                            <td>' . escape($row['username']) . '</td>
                            <td>' . $role . '</td>
                            <td>
                            <select name="' . escape($row['username']) . '">
                                <option value="none" selected disabled hidden>調整權限</option>
                                <option value="0">停權</option>
                                <option value="1">管理員</option>
                                <option value="99">一般成員</option>
                            </select></td>
                            </tr>';
                            $i++;
                        }
                        ?>
                    </table>
                </div>
                <?php
                if (isset($_GET['errCode'])) {
                    switch (escape($_GET['errCode'])) {
                        case '1':
                            $errMsg = '請輸入帳號密碼';
                            break;
                        case '2':
                            $errMsg = '帳號未註冊';
                            break;
                        case '3':
                            $errMsg = '密碼錯誤';
                            break;
                        default:
                            $errMsg = '';
                    }
                    echo '<p class="error_message">' . $errMsg . '</p>';
                }
                ?>
                <input disabled type="submit" value="送出">
            </form>
        </main>
        <script>
            const element = document.querySelectorAll('select');
            element.forEach(el => {
                el.addEventListener('change', function(e) {
                    document.querySelector('input[type="submit"]').disabled = false;
                });
            });
        </script>
    </div>
</body>