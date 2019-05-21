<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nginx Log Viewer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        table, table tr th, table tr td {
            border: 1px solid #000;
        }
        table {
            margin: 0 auto;
            padding: 2px;
            line-height: 20px;
            border-collapse: collapse;
        }
        td {
            padding: 1px 8px;
            white-space: nowrap;
        }
        code {
            display: block;
            overflow: auto;
            max-width: 800px;
        }
        input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            font-size: 18px;
            background: transparent;
        }
        a {
            color: #fff;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            position: fixed;
            right: 10px;
            bottom: 10px;
            line-height: 70px;
            background: #000;
            text-align: center;
            text-decoration: none;
            transition: opacity 0.25s;
            display: none;
            opacity: 0;
        }
    </style>
</head>
<body>
    <a href="javascript:toTop()">回顶部</a>
<?php
    $statusArr = [];
    $total = 0;
    $log = explode("\n", file_get_contents('./access.log'));
    echo '<table><tbody>';
    for ($i = 0;$i < count($log)-1;$i++) {
        $split = explode(' #', $log[$i]);
        if (!in_array($split[4], $statusArr)) array_push($statusArr, $split[4]);
        if (isset($_POST['status']) && $split[4] != $_POST['status']) continue;
        echo '<tr><td><code>客户端IP</code></td><td><code>' . $split[0] . '</code></td></td></tr>';
        echo '<tr><td><code>认证用户名</code></td><td><code>' . $split[1] . '</code></td></tr>';
        echo '<tr><td><code>访问时间</code></td><td><code>' . $split[2] . '</code></td></tr>';
        echo '<tr><td><code>客户端请求地址</code></td><td><code>' . $split[3] . '</code></td></tr>';
        echo '<tr><td><code>状态码</code></td><td><code>' . $split[4] . '</code></td></tr>';
        echo '<tr><td><code>发送的字节数</code></td><td><code>' . $split[5] . '</code></td></tr>';
        echo '<tr><td><code>引用地址</code></td><td><code>' . $split[6] . '</code></td></tr>';
        echo '<tr><td><code>UA</code></td><td><code>' . $split[7] . '</code></td></tr>';
        echo '<tr><td><code>真实IP</code></td><td><code>' . $split[8] . '</code></td></tr>';
        echo '<tr><td><code>SSL协议版本</code></td><td><code>' . $split[9] . '</code></td></tr>';
        echo '<tr><td><code>交换数据算法</code></td><td><code>' . $split[10] . '</code></td></tr>';
        echo '<tr><td><code>上游地址</code></td><td><code>' . $split[11] . '</code></td></tr>';
        echo '<tr><td><code>请求时间</code></td><td><code>' . $split[12] . '</code></td></tr>';
        echo '<tr><td><code>上游响应时间</code></td><td><code>' . $split[13] . '</code></td></tr>';
        echo '<tr style="background: rgba(0,0,0,0.5);"><td colspan="2"><br></td></tr>';
        $total++;
    }
    echo '</tbody></table>';

    echo '<script>document.body.insertAdjacentHTML("afterBegin", "<table style=\'margin:20px auto;text-align:center;\'><tbody><tr><td>状态码</td>';
    sort($statusArr);
    for ($i = 0;$i < count($statusArr);$i++) {
        echo '<td style=\'background:';
        echo isset($_POST['status']) && $_POST['status'] === $statusArr[$i] ? 'rgba(0,0,0,0.3)' : 'transparent';
        echo ';\'><form action=\'\' method=\'post\'><input type=\'submit\' name=\'status\' value='. $statusArr[$i] .' style=\'cursor:pointer;\'></form></td>';
    }
    echo '</tr>';
    echo '<tr><td>记录数</td><td colspan=' . count($statusArr) . '>'. $total .'</td></tr>';
    echo '</tbody></table>")</script>';
?>
</body>
<script>
    window.onload = function () {
        let hideTimeout = null
        window.addEventListener('scroll', function () {
            let top = document.getElementsByTagName('a')[0]
            if (document.documentElement.scrollTop > document.documentElement.clientHeight * 1.5) {
                clearTimeout(hideTimeout)
                top.style.display = 'block'
                setTimeout(function () { top.style.opacity = '1' }, 0)
            } else {
                clearTimeout(hideTimeout)
                top.style.opacity = '0'
                hideTimeout = setTimeout(function () { top.style.display = 'none' }, 300)
            }
        })
    }

    function toTop() {
        let interval = null
        clearInterval(interval)
        let scrollLength = document.documentElement.scrollTop
        interval = setInterval(function () {
            scrollLength /= 1.05
            window.scrollTo(0, scrollLength)
            if (scrollLength <= 1) {
                clearInterval(interval)
                window.scrollTo(0, 0)
            }
        }, 2)
    }

</script>
</html>
