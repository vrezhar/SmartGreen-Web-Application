    async function fetchAsync(url)
    {
        let response = await fetch(url);
        let data = await response.text();
        return data;
    }

    function ConvertToParsableString(text)
    {
    	return text.slice(1,text.length - 3);
    }
    function convertDateToUnixtime() 
    {
        return Math.round((new Date()).getTime() / 1000) + 1;
    }
    function convertUnixtimeToDate(unixtime)
    {
    	return new Date(unixtime*1000);
    }

    function parse_s_podvoxom(response_text)
    {
    	return JSON.parse(ConvertToParsableString(response_text));
    }

    async function getLastSensorData(id)
    {
    	let response = await fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&limt=1&sensor_id="+id);
    	return parse_s_podvoxom(response).data;
    }

    async function getLastSensorRecordTime(id)
    {
    	let response = await fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&limt=1&sensor_id="+id);
    	return parse_s_podvoxom(response).date;
    }
