#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
测试 Bitget 和 Binance WebSocket 延迟
"""

import asyncio
import websockets
import json
import time
from datetime import datetime


class WebSocketLatencyTest:
    """WebSocket 延迟测试类"""
    
    def __init__(self):
        # Bitget WebSocket URL
        self.bitget_url = "wss://ws.bitget.com/v2/ws/public"
        # Binance WebSocket URL
        self.binance_url = "wss://stream.binance.com:9443/ws/btcusdt@trade"
        
        self.latency_records = {
            'bitget': [],
            'binance': []
        }
        
        # 记录被过滤的数据数量
        self.filtered_count = {
            'bitget': 0,
            'binance': 0
        }
    
    async def test_bitget_latency(self, duration=30):
        """测试 Bitget WebSocket 延迟"""
        print(f"\n{'='*60}")
        print(f"开始测试 Bitget WebSocket 延迟...")
        print(f"{'='*60}")
        
        try:
            async with websockets.connect(self.bitget_url) as websocket:
                # 订阅 BTC/USDT 交易数据
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
                print(f"[Bitget] 已发送订阅请求: {subscribe_msg}")
                
                start_time = time.time()
                count = 0
                
                while time.time() - start_time < duration:
                    try:
                        # 记录接收前的时间
                        recv_start = time.time()
                        response = await asyncio.wait_for(websocket.recv(), timeout=5.0)
                        recv_end = time.time()
                        
                        data = json.loads(response)
                        
                        # 如果是交易数据，计算延迟
                        if 'data' in data and isinstance(data['data'], list):
                            for trade in data['data']:
                                # 打印第一条消息的完整数据用于调试
                                if count == 0:
                                    print(f"[Bitget DEBUG] 第一条交易数据: {json.dumps(trade, indent=2)}")
                                
                                # 尝试从不同字段获取时间戳
                                ts_value = None
                                if 'ts' in trade:
                                    ts_value = trade['ts']
                                elif 'timestamp' in trade:
                                    ts_value = trade['timestamp']
                                elif 'time' in trade:
                                    ts_value = trade['time']
                                
                                if ts_value is not None:
                                    try:
                                        # 转换为整数（处理字符串格式）
                                        exchange_ts_ms = int(str(ts_value))
                                        
                                        # 判断时间戳单位（毫秒 vs 微秒）
                                        # 如果时间戳长度>13位，可能是微秒
                                        if exchange_ts_ms > 10000000000000:  # 微秒
                                            exchange_ts = exchange_ts_ms / 1000000.0
                                        else:  # 毫秒
                                            exchange_ts = exchange_ts_ms / 1000.0
                                        
                                        # 本地接收时间
                                        local_ts = recv_end
                                        
                                        # 延迟（毫秒）
                                        latency = (local_ts - exchange_ts) * 1000
                                        
                                        # 调试信息
                                        if count == 0:
                                            print(f"[Bitget DEBUG] 原始ts: {ts_value}")
                                            print(f"[Bitget DEBUG] exchange_ts: {exchange_ts}")
                                            print(f"[Bitget DEBUG] local_ts: {local_ts}")
                                            print(f"[Bitget DEBUG] 延迟: {latency:.2f}ms")
                                        
                                        # 过滤异常数据（延迟绝对值超过500ms的）
                                        # 降低阈值，因为正常延迟应该在100ms以内
                                        if abs(latency) > 500:
                                            self.filtered_count['bitget'] += 1
                                            print(f"[Bitget WARN] 延迟异常 ({latency:.2f}ms)，已跳过 | ts={exchange_ts}, local={local_ts}")
                                            continue
                                        
                                        # 负延迟也过滤掉
                                        if latency < 0:
                                            self.filtered_count['bitget'] += 1
                                            print(f"[Bitget WARN] 负延迟 ({latency:.2f}ms)，已跳过")
                                            continue
                                        
                                        self.latency_records['bitget'].append(latency)
                                        count += 1
                                        
                                        print(f"[Bitget] 消息 #{count} | "
                                              f"延迟: {latency:.2f}ms | "
                                              f"价格: {trade.get('price', 'N/A')} | "
                                              f"数量: {trade.get('size', 'N/A')}")
                                    
                                    except (ValueError, TypeError) as e:
                                        if count < 3:
                                            print(f"[Bitget ERROR] 时间戳转换失败: {ts_value}, 错误: {e}")
                                        continue
                        elif 'event' in data:
                            print(f"[Bitget] 事件响应: {data.get('event')}")
                        else:
                            # 打印未识别的消息格式（仅前3条）
                            if count < 3:
                                print(f"[Bitget DEBUG] 消息格式: {json.dumps(data, indent=2, ensure_ascii=False)[:300]}")
                    
                    except asyncio.TimeoutError:
                        print("[Bitget] 等待数据超时...")
                        continue
                    except Exception as e:
                        print(f"[Bitget] 处理消息错误: {e}")
                        continue
        
        except Exception as e:
            print(f"[Bitget] 连接错误: {e}")
    
    async def test_binance_latency(self, duration=30):
        """测试 Binance WebSocket 延迟"""
        print(f"\n{'='*60}")
        print(f"开始测试 Binance WebSocket 延迟...")
        print(f"{'='*60}")
        
        try:
            async with websockets.connect(self.binance_url) as websocket:
                print(f"[Binance] 已连接到交易流")
                
                start_time = time.time()
                count = 0
                
                while time.time() - start_time < duration:
                    try:
                        # 记录接收前的时间
                        recv_start = time.time()
                        response = await asyncio.wait_for(websocket.recv(), timeout=5.0)
                        recv_end = time.time()
                        
                        data = json.loads(response)
                        
                        # Binance 交易数据格式
                        if 'E' in data:  # 事件时间
                            # 交易所时间戳（毫秒）
                            exchange_ts = int(data['E']) / 1000.0
                            # 本地接收时间
                            local_ts = recv_end
                            # 延迟（毫秒）
                            latency = (local_ts - exchange_ts) * 1000
                            
                            # 过滤异常数据（延迟绝对值超过500ms的）
                            if abs(latency) > 500:
                                self.filtered_count['binance'] += 1
                                print(f"[Binance WARN] 延迟异常 ({latency:.2f}ms)，已跳过")
                                continue
                            
                            # 负延迟也过滤掉
                            if latency < 0:
                                self.filtered_count['binance'] += 1
                                print(f"[Binance WARN] 负延迟 ({latency:.2f}ms)，已跳过")
                                continue
                            
                            self.latency_records['binance'].append(latency)
                            count += 1
                            
                            print(f"[Binance] 消息 #{count} | "
                                  f"延迟: {latency:.2f}ms | "
                                  f"价格: {data.get('p', 'N/A')} | "
                                  f"数量: {data.get('q', 'N/A')}")
                    
                    except asyncio.TimeoutError:
                        print("[Binance] 等待数据超时...")
                        continue
                    except Exception as e:
                        print(f"[Binance] 处理消息错误: {e}")
                        continue
        
        except Exception as e:
            print(f"[Binance] 连接错误: {e}")
    
    async def run_tests(self, duration=30):
        """并行运行两个测试"""
        print(f"\n{'#'*60}")
        print(f"# WebSocket 延迟测试")
        print(f"# 测试时长: {duration} 秒")
        print(f"# 开始时间: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
        print(f"{'#'*60}")
        
        # 并行运行两个测试
        await asyncio.gather(
            self.test_bitget_latency(duration),
            self.test_binance_latency(duration)
        )
        
        # 打印统计结果
        self.print_statistics()
    
    def print_statistics(self):
        """打印统计结果"""
        print(f"\n{'='*60}")
        print(f"延迟统计结果")
        print(f"{'='*60}")
        
        for exchange, latencies in self.latency_records.items():
            if latencies:
                avg_latency = sum(latencies) / len(latencies)
                min_latency = min(latencies)
                max_latency = max(latencies)
                
                print(f"\n[{exchange.upper()}]")
                print(f"  有效样本: {len(latencies)}")
                print(f"  过滤数量: {self.filtered_count.get(exchange, 0)}")
                print(f"  平均延迟: {avg_latency:.2f}ms")
                print(f"  最小延迟: {min_latency:.2f}ms")
                print(f"  最大延迟: {max_latency:.2f}ms")
                
                # 计算百分位
                sorted_latencies = sorted(latencies)
                p50 = sorted_latencies[len(sorted_latencies) // 2]
                p95 = sorted_latencies[int(len(sorted_latencies) * 0.95)]
                p99 = sorted_latencies[int(len(sorted_latencies) * 0.99)]
                
                print(f"  P50延迟: {p50:.2f}ms")
                print(f"  P95延迟: {p95:.2f}ms")
                print(f"  P99延迟: {p99:.2f}ms")
            else:
                print(f"\n[{exchange.upper()}]")
                print(f"  没有收集到数据")


async def main():
    """主函数"""
    tester = WebSocketLatencyTest()
    
    # 运行测试 30 秒（可以修改时长）
    test_duration = 30
    
    try:
        await tester.run_tests(duration=test_duration)
    except KeyboardInterrupt:
        print("\n\n测试被用户中断")
        tester.print_statistics()


if __name__ == "__main__":
    try:
        asyncio.run(main())
    except KeyboardInterrupt:
        print("\n程序退出")

