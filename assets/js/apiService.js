const callApi = async (jsonData, isFormData = false, formData) => {
  try {
    const headers = isFormData ? {} : { "Content-Type": "application/json" };
    const response = await fetch("http://localhost/mechxweight/api", {
      method: "POST",
      headers: headers,
      body: isFormData ? formData : JSON.stringify(jsonData),
    });
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    const data = await response.json();
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

const getAllVehiclesAPI = async (data) =>
  await callApi({ actionMethod: "getallvehicles", ...data });

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
  return res;
};

const deleteParty = async (partyData) => {
  const res = await callApi({
    actionMethod: "deleteparty",
    ...partyData,
  });
  return res;
};

const getAllParties = async (data) =>
  await callApi({ actionMethod: "getallparties", ...data });

const getPartyByIdAPI = async (party_id) => {
  const res = await callApi({
    actionMethod: "getpartybyid",
    party_id,
  });
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
  return res;
};

const getAllMaterialsAPI = async (data) =>
  await callApi({ actionMethod: "getallmaterials", ...data });

const saveLabelConfigAPI = async (labelConfigData) => {
  const res = await callApi({
    actionMethod: "savelabelconfig",
    ...labelConfigData,
  });
  return res;
};

const getLabelConfigAPI = async () =>
  await callApi({ actionMethod: "getlabelconfig" });

const getRecordStatusAPI = async () =>
  await callApi({ actionMethod: "getrecordstatus" });

const insertRecordAPI = async (data) => {
  const res = await callApi({
    actionMethod: "insertrecord",
    ...data,
  });
  return res;
};

const getAllweingRecordsAPI = async (dateobj) =>
  await callApi({ actionMethod: "getalltransactions", ...dateobj });

const getPendingweingRecordsAPI = async (dateobj) =>
  await callApi({ actionMethod: "getpendingtransactions", ...dateobj });

const getCompletedweingRecordsAPI = async (dateobj) =>
  await callApi({ actionMethod: "getcompletedtransactions", ...dateobj });

const updateTransactionStatusAPI = async (data) => {
  const res = await callApi({
    actionMethod: "updatetransactionstatus",
    ...data,
  });
  return res;
};
const getSingleRecordByTicket = async (data) => {
  const res = await callApi({
    actionMethod: "getsinglerecordbyid",
    ...data,
  });
  return res;
};

const regCompanyAPI = async (data) => {
  console.log("api");
  const res = await callApi({
    actionMethod: "regcompany",
    ...data,
  });
  console.log(res);
  return res;
};
const saveCompanyAPI = async (formData) => {
  const res = await callApi({}, true, formData);
  console.log(res);
  return res;
};

const getUserCompany = async ({ user_id, company_id }) =>
  await callApi({ actionMethod: "getcompany", user_id, company_id });
