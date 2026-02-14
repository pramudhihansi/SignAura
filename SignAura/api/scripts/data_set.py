import cv2
import mediapipe as mp
import pandas as pd
import os

# ---------------- SETTINGS ----------------
# Use relative path from api/scripts/ to ml-models/datasets/
DATASET_DIR = os.path.join(os.path.dirname(__file__), "..", "..", "ml-models", "datasets", "raw")
OUTPUT_FILE = os.path.join(os.path.dirname(__file__), "..", "..", "ml-models", "datasets", "new_all_hand_landmarks.csv")

# Create raw dataset folder if it doesn't exist
os.makedirs(DATASET_DIR, exist_ok=True)

mp_hands = mp.solutions.hands
hands = mp_hands.Hands(
    static_image_mode=False,
    max_num_hands=1,
    min_detection_confidence=0.5
)

# ---------------------------------------
# Process a single image
# ---------------------------------------
def process_image(image_path):
    img = cv2.imread(image_path)
    if img is None:
        print("❌ Cannot read:", image_path)
        return None

    img_rgb = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
    results = hands.process(img_rgb)

    if not results.multi_hand_landmarks:
        print("⚠ No hand detected:", image_path)
        return None

    landmarks = results.multi_hand_landmarks[0]
    row = []

    for lm in landmarks.landmark:
        row.extend([lm.x, lm.y, lm.z])

    return row


# ---------------------------------------
# Process a video file (frame by frame)
# ---------------------------------------
def process_video(video_path):
    cap = cv2.VideoCapture(video_path)

    frame_index = 0
    rows = []

    if not cap.isOpened():
        print("❌ Cannot open video:", video_path)
        return rows

    while True:
        ret, frame = cap.read()
        if not ret:
            break  # End of video

        img_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        results = hands.process(img_rgb)

        if results.multi_hand_landmarks:
            landmarks = results.multi_hand_landmarks[0]
            row = []

            for lm in landmarks.landmark:
                row.extend([lm.x, lm.y, lm.z])

            rows.append((frame_index, row))
        else:
            print(f"⚠ No hand detected in frame {frame_index} of {video_path}")

        frame_index += 1

    cap.release()
    return rows


# ---------------- RUN ----------------
all_rows = []

IMAGE_EXT = ('.jpg', '.jpeg', '.png')
VIDEO_EXT = ('.mp4', '.avi', '.mov', '.mkv')

for root, dirs, files in os.walk(DATASET_DIR):
    for file in files:

        full_path = os.path.join(root, file)
        folder_name = os.path.basename(os.path.dirname(full_path))
        file_name = os.path.basename(full_path)

        # -----------------------------------------
        # Process Images
        # -----------------------------------------
        if file.lower().endswith(IMAGE_EXT):
            print("🖼 Processing Image:", full_path)

            row = process_image(full_path)
            if row is None:
                continue

            all_rows.append([folder_name, file_name, 0] + row)  # frame=0 for images

        # -----------------------------------------
        # Process Videos
        # -----------------------------------------
        elif file.lower().endswith(VIDEO_EXT):
            print("🎥 Processing Video:", full_path)

            video_rows = process_video(full_path)

            for frame_idx, row in video_rows:
                all_rows.append([folder_name, file_name, frame_idx] + row)


# --------- Column Names ---------
col_names = ["folder", "file_name", "frame"]
for i in range(21):
    col_names += [f"x{i}", f"y{i}", f"z{i}"]

# Save CSV
df = pd.DataFrame(all_rows, columns=col_names)
df.to_csv(OUTPUT_FILE, index=False)

print(f"\n🎉 DONE — All images/videos processed into {OUTPUT_FILE}!")
