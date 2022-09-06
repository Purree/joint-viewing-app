import replaceDataInUri from "@/helpers/replaceDataInUri";

export default (method, replacement = {}, additionalData = null, headers = null) => {
    return axios[method[0]](replaceDataInUri(method[1], replacement), additionalData, headers)
}
