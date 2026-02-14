import pandas as pd
from sklearn.model_selection import train_test_split

# Load CSV
df = pd.read_csv("Data_set_new.csv")

# Label column
label_col = "folder"

# Features = numeric landmarks only
X = df.drop(["folder", "file_name", "frame"], axis=1)
y = df[label_col]

# ---- Step 1: Split into Train (80%) and Temp (20%) ----
X_train, X_temp, y_train, y_temp = train_test_split(
    X, y, test_size=0.2, random_state=42, shuffle=True
)

# ---- Step 2: Split Temp (20%) into Test (15%) and Test-Test (5%) ----
# Since X_temp is 20% of total, we need:
# test_size = 0.05 / 0.2 = 0.25 → 25% of temp = 5% total
X_test, X_test_test, y_test, y_test_test = train_test_split(
    X_temp, y_temp, test_size=0.25, random_state=42, shuffle=True
)

# ---- Combine features + labels back ----
train_df = pd.concat([X_train, y_train], axis=1)
test_df = pd.concat([X_test, y_test], axis=1)
test_test_df = pd.concat([X_test_test, y_test_test], axis=1)

# ---- Save CSVs ----
train_df.to_csv("train_data.csv", index=False)
test_df.to_csv("test_data.csv", index=False)
test_test_df.to_csv("test_test_data.csv", index=False)

print("Train, Test, and Test-Test CSVs created successfully!")
