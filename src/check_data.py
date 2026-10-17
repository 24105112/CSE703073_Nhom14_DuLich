import re
from collections import Counter
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
SQL_FILE = ROOT / "accessible_destinations.sql"

text = SQL_FILE.read_text(encoding="utf-8-sig")

pattern = re.compile(
    r"insert\s+into\s+accessible_destinations\s*"
    r"\(id,\s*title,\s*accessibility_features,\s*city,\s*rating\)"
    r"\s*values\s*\(\s*(\d+)\s*,\s*"
    r"'((?:''|[^'])*)'\s*,\s*"
    r"'((?:''|[^'])*)'\s*,\s*"
    r"'((?:''|[^'])*)'\s*,\s*"
    r"([0-9]+(?:\.[0-9]+)?)\s*\)\s*;",
    re.IGNORECASE,
)

records = []

for match in pattern.finditer(text):
    record_id, title, features, city, rating = match.groups()

    records.append({
        "id": int(record_id),
        "title": title.replace("''", "'"),
        "features": features.replace("''", "'"),
        "city": city.replace("''", "'"),
        "rating": float(rating),
    })

print(f"Tổng số bản ghi đọc được: {len(records)}")

if not records:
    print("Không đọc được bản ghi nào. Cần kiểm tra cấu trúc SQL.")
    raise SystemExit(1)

print("\nSố bản ghi theo thành phố:")
for city, count in Counter(r["city"] for r in records).most_common():
    print(f"- {city}: {count}")

print("\nDanh sách địa điểm và thành phố đang được gán:")
titles = sorted(set(r["title"] for r in records))

for title in titles:
    cities = sorted(set(
        r["city"] for r in records if r["title"] == title
    ))
    count = sum(1 for r in records if r["title"] == title)
    print(f"- {title} | Số dòng: {count} | Thành phố: {', '.join(cities)}")

