from pathlib import Path
import re

ROOT = Path(r"c:\Users\Goodie\Desktop\taaRename\resources\views")

PAGES = {
    "dashboard.blade.php": "Dashboard",
    "companies.blade.php": "Companies",
    "users.blade.php": "Users",
    "hrm.blade.php": "HRM",
    "finance.blade.php": "Finance",
    "equity.blade.php": "Equity",
    "sales.blade.php": "Sales",
    "inventory.blade.php": "Inventory",
    "loan.blade.php": "Loans",
    "far.blade.php": "Fixed Asset Register",
    "vat-account.blade.php": "VAT Account",
    "reports.blade.php": "Reports",
    "settings.blade.php": "Settings",
    "production.blade.php": "Production & Hatchery",
    "machine.blade.php": "Machine Monitoring",
    "messages/index.blade.php": "Communication",
    "finance/reviewexpenses.blade.php": "Expense Review",
}

HEADER_RE = re.compile(
    r"<!DOCTYPE html>.*?@include\('components\.sidebar'\)\s*",
    re.DOTALL | re.IGNORECASE,
)

CLOSE_RE = re.compile(r"</body>\s*</html>\s*$", re.IGNORECASE)

SHARED = [
    re.compile(r"^[ \t]*@include\('components\.modal'\)[ \t]*\n", re.MULTILINE),
    re.compile(r"^[ \t]*@include\('components\.alert'\)[ \t]*\n", re.MULTILINE),
    re.compile(r"^[ \t]*@include\('components\.confirm'\)[ \t]*\n", re.MULTILINE),
    re.compile(r"^[ \t]*<x-alert\s*/>[ \t]*\n", re.MULTILINE),
]


def convert(rel: str, title: str) -> None:
    path = ROOT / rel
    text = path.read_text(encoding="utf-8")
    extra = ""

    if rel == "messages/index.blade.php":
        extra = "@section('bodyClass', 'overflow-x-hidden')\n\n"

    header = f"@extends('layouts.app')\n\n@section('title', {title!r})\n\n{extra}@section('content')\n"
    text, n = HEADER_RE.subn(header, text, count=1)
    if n != 1:
        raise SystemExit(f"Header replace failed: {rel}")

    for pattern in SHARED:
        text = pattern.sub("", text)

    text, n = CLOSE_RE.subn("@endsection\n", text)
    if n != 1:
        raise SystemExit(f"Close replace failed: {rel}")

    path.write_text(text, encoding="utf-8", newline="\n")
    print(f"OK {rel}")


for rel, title in PAGES.items():
    convert(rel, title)

print("done")
