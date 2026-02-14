import pandas as pd
from sklearn.preprocessing import LabelEncoder
import pickle
import os

# =========================================
# FILE NAMES
# =========================================
INPUT_CSV = "labels_new.csv"
OUTPUT_CSV = "encoded_labels_382.csv"
ENCODER_FILE = "label_encoder_382.pkl"

# =========================================
# 1. CHECK FILE EXISTS
# =========================================
if not os.path.exists(INPUT_CSV):
    raise FileNotFoundError(f"❌ '{INPUT_CSV}' not found in project folder")

# =========================================
# 2. LOAD CSV
# =========================================
df = pd.read_csv(INPUT_CSV, encoding="utf-8")

# =========================================
# 3. AUTO-DETECT LANGUAGE COLUMNS
# =========================================
cols = [c.lower().strip() for c in df.columns]

def find_col(name):
    for col in df.columns:
        if col.lower().strip() == name:
            return col
    return None

en_col = find_col("english")
si_col = find_col("sinhala")
ta_col = find_col("tamil")

if not all([en_col, si_col, ta_col]):
    raise ValueError(
        "❌ Could not find required columns.\n"
        f"Found columns: {list(df.columns)}\n"
        "CSV must contain English, Sinhala, Tamil columns."
    )

print(f"✅ Columns detected: {en_col}, {si_col}, {ta_col}")
print(f"✅ Loaded {len(df)} labels")

# =========================================
# 4. CLEAN DATA (IMPORTANT)
# =========================================
df = df[[en_col, si_col, ta_col]].dropna()

df[en_col] = df[en_col].astype(str).str.strip()
df[si_col] = df[si_col].astype(str).str.strip()
df[ta_col] = df[ta_col].astype(str).str.strip()

# =========================================
# 5. COMBINE LABELS
# =========================================
df["combined_label"] = (
    df[en_col] + "|" +
    df[si_col] + "|" +
    df[ta_col]
)

# =========================================
# 6. ENCODE LABELS
# =========================================
le = LabelEncoder()
df["encoded_label"] = le.fit_transform(df["combined_label"])

# =========================================
# 7. SAVE ENCODER
# =========================================
with open(ENCODER_FILE, "wb") as f:
    pickle.dump(le, f)

# =========================================
# 8. SAVE FINAL CSV
# =========================================
df.rename(columns={
    en_col: "english",
    si_col: "sinhala",
    ta_col: "tamil"
}, inplace=True)

df.to_csv(OUTPUT_CSV, index=False, encoding="utf-8-sig")

# =========================================
# 9. SUCCESS MESSAGE
# =========================================
print("🎉 Encoding completed successfully!")
print(f"Total classes : {len(le.classes_)}")
print(f"Saved CSV     : {OUTPUT_CSV}")
print(f"Saved encoder : {ENCODER_FILE}")

# =========================================
# 10. TEST DECODE
# =========================================
test_index = 0
decoded = le.inverse_transform([test_index])[0]
en, si, ta = decoded.split("|")

print("\n🧪 Test decode:")
print("English :", en)
print("Sinhala :", si)
print("Tamil   :", ta)
