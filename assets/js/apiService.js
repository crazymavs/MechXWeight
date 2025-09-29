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

const inserNewVehicleAPI = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "insertvehicle",
    ...vehicleData,
  });
  return res;
};

const deleteVehicleAPI = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "deletevehicle",
    ...vehicleData,
  });
  return res;
};

const getAllVehiclesAPI = async () =>
  await callApi({ actionMethod: "getallvehicles" });

const insertNewParty = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "insertparty",
    ...vehicleData,
  });
  return res;
};

const getVehicleByIdAPI = async (vehicle_id) => {
  const res = await callApi({
    actionMethod: "getvehiclebyid",
    vehicle_id,
  });
  console.log({ res });
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

const getPartyByIdAPI = async (party_id) => {
  const res = await callApi({
    actionMethod: "getpartybyid",
    party_id,
  });
  console.log({ res });
  return res;
};

const insertNewMaterialAPI = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "insertmaterial",
    ...vehicleData,
  });
  return res;
};

const deleteMaterialAPI = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "deletematerial",
    ...vehicleData,
  });
  return res;
};

const updateMaterialAPI = async (materialData) => {
  const res = await callApi({
    actionMethod: "updatematerial",
    ...materialData,
  });
  return res;
};

const getMaterialByIdAPI = async (material_id) => {
  const res = await callApi({
    actionMethod: "getmaterialbyid",
    material_id,
  });
  console.log({ res });
  return res;
};

const getAllMaterialsAPI = async () =>
  await callApi({ actionMethod: "getallmaterials" });
