const callApi = async (jsonData) => {
  const response = await fetch("http://localhost/mechxweight/api", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(jsonData),
  });
  return response;
};

const inserNewVehicle = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "insertvehicle",
    ...vehicleData,
  });
  return res;
};

const getAllVehicles = async () =>
  await callApi({ actionMethod: "getallvehicles" });

const inserNewParty = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "insertparty",
    ...vehicleData,
  });
  return res;
};

const getAllParties = async () =>
  await callApi({ actionMethod: "getallparties" });

const inserNewMaterial = async (vehicleData) => {
  const res = await callApi({
    actionMethod: "createnewpart",
    ...vehicleData,
  });
  return res;
};

const getAllMaterial = async () =>
  await callApi({ actionMethod: "getallparties" });
