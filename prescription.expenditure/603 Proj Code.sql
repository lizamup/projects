CREATE TABLE kaggle (
    year NUMBER,
    gender VARCHAR2(10),
    age NUMBER,
    location VARCHAR2(50),
    race_AfricanAmerican NUMBER,
    race_Asian NUMBER,
    race_Caucasian NUMBER,
    race_Hispanic NUMBER,
    race_Other NUMBER,
    hypertension NUMBER,
    heart_disease NUMBER,
    smoking_history VARCHAR2(30),
    bmi NUMBER,
    hbA1c_level NUMBER,
    blood_glucose_level NUMBER,
    diabetes NUMBER,
    clinical_notes CLOB,
    bmi_classification VARCHAR2(30),
    lifestyle_observation VARCHAR2(100)
);


SELECT COUNT(*) FROM kaggle;




CREATE TABLE stroke_data AS
SELECT
  year,
  gender,
  age,
  location,
  AfricanAmerican,
  Asian,
  Caucasian,
  Hispanic,
  Other,
  hypertension,
  heart_disease,
  smoking_history,
  bmi,
  hbA1c_level,
  blood_glucose_level,
  diabetes,
  clinical_notes,
  bmi_classification,
  lifestyle_observation,
  CASE 
    WHEN hypertension = 1 AND diabetes = 1 AND age > 50 THEN 1
    ELSE 0
  END AS stroke_risk_flag
FROM KAGGLE;


SELECT * FROM stroke_data
WHERE stroke_risk_flag = 1;


DROP TABLE stroke_cleaned; 
CREATE TABLE stroke_cleaned AS
SELECT *
FROM stroke_data
WHERE age IS NOT NULL
  AND bmi IS NOT NULL
  AND smoking_history IS NOT NULL
  AND hbA1c_level IS NOT NULL
  AND blood_glucose_level IS NOT NULL;


ALTER TABLE stroke_cleaned ADD smoking_code NUMBER;


UPDATE stroke_cleaned
SET smoking_code = CASE 
  WHEN smoking_history = 'never' THEN 0
  WHEN smoking_history = 'not current' THEN 1
  WHEN smoking_history = 'current' THEN 2
  ELSE NULL
END;


ALTER TABLE stroke_cleaned ADD bmi_class VARCHAR2(20);


UPDATE stroke_cleaned
SET bmi_class = CASE
  WHEN bmi < 18.5 THEN 'underweight'
  WHEN bmi BETWEEN 18.5 AND 24.9 THEN 'healthy'
  WHEN bmi BETWEEN 25 AND 29.9 THEN 'overweight'
  ELSE 'obese'
END;


ALTER TABLE stroke_cleaned ADD gender_code NUMBER;


UPDATE stroke_cleaned
SET gender_code = CASE
  WHEN gender = 'Male' THEN 0
  WHEN gender = 'Female' THEN 1
  ELSE NULL
END;


SELECT 
  age,
  bmi,
  smoking_code,
  diabetes,
  hypertension,
  heart_disease,
  blood_glucose_level,
  hbA1c_level,
  gender_code,
  stroke_risk_flag
FROM stroke_cleaned;