# nginx-log-viewer

### 请将日志改为以下格式
```
log_format main '$remote_addr #$remote_user #$time_local #$request '
                '#$status #$body_bytes_sent #$http_referer '
                '#$http_user_agent #$http_x_forwarded_for '
                '#$ssl_protocol #$ssl_cipher #$upstream_addr '
                '#$request_time #$upstream_response_time';
```
