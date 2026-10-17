
import argparse
import logging
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
DATA_FILE = ROOT / "accessible_destinations.sql"
LOG_FILE = ROOT / "recommend.log"
BACKUP_LOG = ROOT / "backup.log"

INSERT_PATTERN = re.compile(
    r"insert\s+into\s+accessible_destinations\s*"
    r"\(id,\s*title,\s*accessibility_features,\s*city,\s*rating\)"
    r"\s*values\s*\(\s*(\d+)\s*,\s*"
    r"'((?:''|[^'])*)'\s*,\s*"
    r"'((?:''|[^'])*)'\s*,\s*"
    r"'((?:''|[^'])*)'\s*,\s*"
    r"([0-9]+(?:\.[0-9]+)?)\s*\)",
    re.IGNORECASE,
)


def setup_logging():
    logger = logging.getLogger("travel_recommend")
    logger.setLevel(logging.INFO)
    logger.handlers.clear()

    formatter = logging.Formatter(
        "%(asctime)s | %(levelname)s | %(message)s"
    )

    for path in (LOG_FILE, BACKUP_LOG):
        handler = logging.FileHandler(path, encoding="utf-8")
        handler.setFormatter(formatter)
        logger.addHandler(handler)

    console = logging.StreamHandler()
    console.setFormatter(formatter)
    logger.addHandler(console)

    return logger


def load_destinations(logger):
    if not DATA_FILE.exists():
        logger.error("Khong tim thay file: %s", DATA_FILE)
        raise FileNotFoundError(DATA_FILE)

    content = DATA_FILE.read_text(encoding="utf-8-sig")
    destinations = []

    for match in INSERT_PATTERN.finditer(content):
        record_id, title, features, city, rating = match.groups()

        destinations.append({
            "id": int(record_id),
            "title": title.replace("''", "'"),
            "accessibility_features": features.replace("''", "'"),
            "city": city.replace("''", "'"),
            "rating": float(rating),
        })

    if not destinations:
        logger.error("Khong doc duoc ban ghi nao tu file SQL.")
        raise ValueError("Khong co du lieu hop le.")

    logger.info("Da doc duoc %d ban ghi.", len(destinations))

    if len(destinations) < 300:
        logger.warning(
            "Chi co %d ban ghi trong file SQL; can kiem tra yeu cau 300 ban ghi.",
            len(destinations),
        )

    return destinations


def recommend(destinations, city=None, need=None, top=5):
    results = destinations

    if city:
        results = [
            item for item in results
            if city.casefold() in item["city"].casefold()
        ]

    if need:
        results = [
            item for item in results
            if need.casefold()
            in item["accessibility_features"].casefold()
        ]

    return sorted(
        results,
        key=lambda item: item["rating"],
        reverse=True,
    )[:top]


def main():
    parser = argparse.ArgumentParser(
        description="Goi y diem den du lich tiep can."
    )
    parser.add_argument("--city", help="Loc theo thanh pho")
    parser.add_argument("--need", help="Loc theo nhu cau tiep can")
    parser.add_argument("--top", type=int, default=5)
    args = parser.parse_args()

    logger = setup_logging()

    try:
        if args.top < 1:
            raise ValueError("--top phai lon hon hoac bang 1.")

        destinations = load_destinations(logger)
        results = recommend(
            destinations,
            city=args.city,
            need=args.need,
            top=args.top,
        )

        if not results:
            logger.warning("Khong tim thay diem den phu hop.")
            print("Khong tim thay diem den phu hop.")
            return

        print("\n=== KET QUA GOI Y ===")
        for item in results:
            print(
                f"\nTen: {item['title']}"
                f"\nThanh pho: {item['city']}"
                f"\nTinh nang tiep can: {item['accessibility_features']}"
                f"\nDanh gia: {item['rating']}/5"
            )

        logger.info("Goi y thanh cong: %d ket qua.", len(results))

    except (OSError, ValueError) as error:
        logger.error("Khong the thuc hien goi y: %s", error)
        print("Loi:", error)


if __name__ == "__main__":
    main()
