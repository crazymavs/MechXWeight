const callApi = async (jsonData) => {
  try {
    const response = await fetch("http://localhost/mechxweight/api", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(jsonData),
    });

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
    console.log({ data });
    return data;
  } catch (error) {
    throw error;
  }
};

const inserNewVehicle = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "insertvehicle",
    ...vehicleData,
  });
  return res;
};
const deleteVehicle = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "deletevehicle",
    ...vehicleData,
  });
  return res;
};

const getAllVehicles = async () =>
  await callApi({ actionMethod: "getallvehicles" });

const insertNewParty = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "insertparty",
    ...vehicleData,
  });
  return res;
};
const deleteParty = async (partyData) => {
  const res = await callApi({
    actionMethod: "deleteparty",
    ...partyData,
  });
  return res;
};

const getAllParties = async () =>
  await callApi({ actionMethod: "getallparties" });

const insertNewMaterial = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "insertmaterial",
    ...vehicleData,
  });
  return res;
};
const deleteMaterial = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "deletematerial",
    ...vehicleData,
  });
  return res;
};

const getAllMaterial = async () =>
  await callApi({ actionMethod: "getallparties" });
