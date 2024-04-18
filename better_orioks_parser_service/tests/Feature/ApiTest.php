<?php

class ApiTest extends \Tests\TestCase{
    public function test_api_get_marks_auth_successful():void
    {
        $response = $this -> getJson('/api/v1/marks?Auth-String=eyJpdiI6IlF1RkpmaG5QcW5zK2hyRzBXN0dMZ0E9PSIsInZhbHVlIjoiK09wTUdxWVRtbFpYeUJOS1JLZ0lPOURjYTVzbzlEYUE2SWY3VWE4a0xFb0FkRXBnQjdDc3NPVUgxMi9GU1p5bjZLQjFsV04yQUhvYXVSS0xxTnc3dmdXZEFTamY5YW9QaGc5TldFN0tUZlhtTHI3QTJVb0tBNjA0T3owcDFjZEdIdm96MFVZUWZsdWl5OGhEaXd5V3JNUmEvOVhUanoydzBGbU1sVVFKbTRWSGp6U0tudFVEZ2ltd2ppaGMwOGcvdUIybmx0VnZscnpoQ3dkdkhSOFdaOFlRT1V5c3dnTWZ1VmNiU21Hbmo4WTZqWHNIeUVrMFp5REJveVk2REVMdHdrR2haUjBVSTR6ZUYvRkRNK0d2RTEzT3NMVmpDcHUzZmhtWDlNWlo0NVBxV2NtbU5XUEkrS0N4czh4bEJyOXlhUHRXWUFzLzVLRmNMZGwva01XUFlUSFJUVXZ1NU9YYys3ZXNqbTdwSjJBbEdCUVRob1FhTFBQU1pJcCtpcEFFY3MwdlJheFdXMFkxaisyZU9aU2R2UGtCeHF5M2RzY0VxdkdGKzBtd2xHV01pWUEwdXU2c2tiL04vaTd3TkpXZ1lNejVnQjJ1NmVFV3IrV3VSRlBMS09pYzIxemtLSGE2cnNnaEhtY2RxazZaa29JSHVYVjR2M3VXandDZXZUaC9CNmpaSDZUS3pnRmhFNzViQU9aZ2IvQit0WlZzRTg3enUxUGQ0Zzd4RWpqOTd4VFBZTXdxQWRSSllFd0N4MmlDcXlXamx5UFd3T0lEKzQrZ3c3YWk3UT09IiwibWFjIjoiODQwNzgxMjkxYTVhOGY2Y2U5MDZiNGIwZTk2YjA2OTdhNjM4NGRlMDU3MmFkNTM2OWZlYWZjY2ZhYmNmNjVkNSIsInRhZyI6IiJ9');
        $response -> assertStatus(200);
    }

    public function test_api_get_marks_auth_failed():void
    {
        $response = $this -> getJson('/api/v1/marks?Auth-String=');
        $response -> assertStatus(200);
    }

    public function test_api_get_news_auth_successful():void
    {
        $response = $this -> getJson('/api/v1/news?Auth-String=eyJpdiI6IlF1RkpmaG5QcW5zK2hyRzBXN0dMZ0E9PSIsInZhbHVlIjoiK09wTUdxWVRtbFpYeUJOS1JLZ0lPOURjYTVzbzlEYUE2SWY3VWE4a0xFb0FkRXBnQjdDc3NPVUgxMi9GU1p5bjZLQjFsV04yQUhvYXVSS0xxTnc3dmdXZEFTamY5YW9QaGc5TldFN0tUZlhtTHI3QTJVb0tBNjA0T3owcDFjZEdIdm96MFVZUWZsdWl5OGhEaXd5V3JNUmEvOVhUanoydzBGbU1sVVFKbTRWSGp6U0tudFVEZ2ltd2ppaGMwOGcvdUIybmx0VnZscnpoQ3dkdkhSOFdaOFlRT1V5c3dnTWZ1VmNiU21Hbmo4WTZqWHNIeUVrMFp5REJveVk2REVMdHdrR2haUjBVSTR6ZUYvRkRNK0d2RTEzT3NMVmpDcHUzZmhtWDlNWlo0NVBxV2NtbU5XUEkrS0N4czh4bEJyOXlhUHRXWUFzLzVLRmNMZGwva01XUFlUSFJUVXZ1NU9YYys3ZXNqbTdwSjJBbEdCUVRob1FhTFBQU1pJcCtpcEFFY3MwdlJheFdXMFkxaisyZU9aU2R2UGtCeHF5M2RzY0VxdkdGKzBtd2xHV01pWUEwdXU2c2tiL04vaTd3TkpXZ1lNejVnQjJ1NmVFV3IrV3VSRlBMS09pYzIxemtLSGE2cnNnaEhtY2RxazZaa29JSHVYVjR2M3VXandDZXZUaC9CNmpaSDZUS3pnRmhFNzViQU9aZ2IvQit0WlZzRTg3enUxUGQ0Zzd4RWpqOTd4VFBZTXdxQWRSSllFd0N4MmlDcXlXamx5UFd3T0lEKzQrZ3c3YWk3UT09IiwibWFjIjoiODQwNzgxMjkxYTVhOGY2Y2U5MDZiNGIwZTk2YjA2OTdhNjM4NGRlMDU3MmFkNTM2OWZlYWZjY2ZhYmNmNjVkNSIsInRhZyI6IiJ9');
        $response -> assertStatus(200);
    }

    public function test_api_get_news_auth_failed():void
    {
        $response = $this -> getJson('/api/v1/news');
        $response -> assertStatus(200);
    }
}