import json
import os
import math
import re
import urllib.request

def fetch_tour_data():
    # Gọi API cục bộ của dự án trên XAMPP
    url = "http://localhost/CSE703073_Nhom14_DuLich/api/get_tours.php"
    try:
        req = urllib.request.urlopen(url)
        res = json.loads(req.read().decode('utf-8'))
        return res.get('data', [])
    except Exception as e:
        print(f"[Lưu ý] Không kết nối được API: {e}. Sử dụng dữ liệu dự phòng.")
        return [
            {"id": 1, "ten_tour": "Du thuyền Ambassador Vịnh Hạ Long", "dia_diem": "Quảng Ninh", "gia_tien": 3200000, "mo_ta_ngan": "thang máy boong tàu dốc tiếp cận xe lăn", "danh_gia_sao": 4.8},
            {"id": 4, "ten_tour": "Du thuyền Heritage Bình Chuẩn Cát Bà", "dia_diem": "Hải Phòng", "gia_tien": 3800000, "mo_ta_ngan": "thang cuốn cửa mở rộng 95cm xe lăn điện", "danh_gia_sao": 4.9},
            {"id": 8, "ten_tour": "InterContinental Danang Sun Peninsula Resort", "dia_diem": "Đà Nẵng", "gia_tien": 8900000, "mo_ta_ngan": "tàu điện nghiêng Nam Tram vận chuyển xe lăn 4 tầng", "danh_gia_sao": 5.0},
            {"id": 3, "ten_tour": "Quần thể Di tích Cố đô Huế Không Rào Cản", "dia_diem": "Thừa Thiên Huế", "gia_tien": 850000, "mo_ta_ngan": "rãnh dốc tiếp cận cổng Ngọ Môn và điện Thái Hòa", "danh_gia_sao": 4.7}
        ]

def compute_accessibility_score(text, keywords):
    words = re.findall(r'\w+', (text or '').lower())
    if not words:
        return 0.0
    match_count = sum(1 for w in keywords if w in words)
    return round(match_count / math.sqrt(len(words) + 1), 3)

def main():
    print("=" * 60)
    print(" [Python AI Module - Mốc M3] Phân Tích Dữ Liệu Du Lịch Tiếp Cận ")
    print("=" * 60)
    
    tours = fetch_tour_data()
    keywords = ["thang", "máy", "xe", "lăn", "dốc", "ram", "tiếp", "cận", "rộng", "tay", "vịn"]
    
    analyzed_list = []
    for t in tours:
        desc = t.get('mo_ta_ngan', '')
        score = compute_accessibility_score(desc, keywords)
        analyzed_list.append({
            "id": t.get('id'),
            "ten_tour": t.get('ten_tour'),
            "dia_diem": t.get('dia_diem'),
            "gia_tien": float(t.get('gia_tien', 0)),
            "avg_rating": float(t.get('danh_gia_sao', 5.0)),
            "ai_accessibility_score": score
        })
        
    # Sắp xếp lấy Top 3 Tour tối ưu nhất cho xe lăn
    analyzed_list.sort(key=lambda x: (x['ai_accessibility_score'], x['avg_rating']), reverse=True)
    top_3 = analyzed_list[:3]
    
    output_data = {
        "status": "success",
        "model_version": "v1.2-CosineAccessibilityScore",
        "summary": {
            "total_tours_analyzed": len(tours),
            "algorithm": "Content-Based Accessibility Filtering (Python 3.12)"
        },
        "recommended_tours_for_wheelchair": top_3
    }
    
    # Xuất file kết quả ra thư mục api/
    output_dir = os.path.join(os.path.dirname(__file__), '..', 'api')
    os.makedirs(output_dir, exist_ok=True)
    output_path = os.path.join(output_dir, 'analytics_result.json')
    
    with open(output_path, 'w', encoding='utf-8') as f:
        json.dump(output_data, f, ensure_ascii=False, indent=4)
        
    print(f"✔ Đã phân tích thành công {len(tours)} tour!")
    print(f"✔ Kết quả JSON đã được ghi tại: {output_path}")
    print("=" * 60)

if __name__ == '__main__':
    main()