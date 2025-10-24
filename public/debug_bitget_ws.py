#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
调试 Bitget WebSocket 返回数据格式
"""

import asyncio
import websockets
import json
import time


async def debug_bitget():
    """调试Bitget WebSocket返回数据"""
    url = "wss://ws.bitget.com/v2/ws/public"
    
    print("连接到 Bitget WebSocket...")
    
    async with websockets.connect(url) as websocket:
        # 订阅消息
        subscribe_msg = {
            "op": "subscribe",
            "args": [
                {
                    "instType": "SPOT",
                    "channel": "trade",
                    "instId": "BTCUSDT"
                }
            ]
        }
        
        await websocket.send(json.dumps(subscribe_msg))
        print(f"已发送订阅: {subscribe_msg}\n")
        
        # 接收前5条消息
        for i in range(5):
            response = await websocket.recv()
            data = json.loads(response)
            
            print(f"\n{'='*60}")
            print(f"消息 #{i+1}")
            print(f"{'='*60}")
            print(json.dumps(data, indent=2, ensure_ascii=False))
            
            # 如果有时间戳，打印详细信息
            if 'data' in data:
                print(f"\n时间戳信息:")
                if isinstance(data['data'], list):
                    for idx, item in enumerate(data['data']):
                        if 'ts' in item:
                            ts_value = item['ts']
                            print(f"  记录 {idx}: ts = {ts_value} (类型: {type(ts_value).__name__})")
                            
                            # 尝试转换
                            try:
                                ts_int = int(ts_value)
                                print(f"    整数值: {ts_int}")
                                print(f"    作为毫秒: {ts_int / 1000.0} 秒")
                                print(f"    作为秒: {ts_int} 秒")
                                print(f"    当前时间: {time.time()} 秒")
                                print(f"    差值(毫秒): {(time.time() - ts_int / 1000.0) * 1000:.2f} ms")
                            except:
                                print(f"    无法转换为整数")


if __name__ == "__main__":
    asyncio.run(debug_bitget())

