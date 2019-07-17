
    async function fetchAsync(url)
    {
        let response = await fetch(url);
        let data = await response.json();
        return data;
    }

/*
    function ConvertToParsableString(text)
    {
    	return text.slice(1,text.length - 3);
    }
*/

    function convertCurrentDateToUnixtime() 
    {
        return Math.round((new Date()).getTime() / 1000) + 1;
    }
    function convertUnixtimeToDate(unixtime)
    {
    	return new Date(unixtime*1000);
    }
    async function getLastSensorRecordDate(id)
    {
        let response = await fetchAsync("http://smartgreen.cc/demo/api/api_GET.php?getSensorData&sensor_id="+id+"&limit=1");
        return convertUnixtimeToDate(response[0]['date']);
    }    

/*
    function parse_s_podvoxom(response_text)
    {
    	return JSON.parse(ConvertToParsableString(response_text));
    }
*/

    async function getLastSensorData(id)
    {
    	let response_string = await fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&limit=1&sensor_id="+id);
    	return response[0]['data'];
    }

    async function getLastSensorRecordTime(id)
    {
    	let response = await fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&sensor_id="+id);
    	return response[0]['date'];
    }


    async function getSensorDataByIdStartingFrom(id,from)
    {
        let result = [];
        var response;
        var last_record_number; 
        if(from === undefined)
            from = 0;                
        fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&limit=1&sensor_id="+id)
        .then(data=>
        {
            //console.log(data[0]);
            last_record_number = data[0]['sensor_data_id'];
            //console.log(last_record_number);
            if(from === undefined)
                from = 0;
            fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&sensor_id="
                       +id+"&limit="+last_record_number+"&from="+from)
            .then(data=>
                {
                    response = data;
                    for (var i = 0; i <= last_record_number; ++i) 
                    {
                        //console.log(response[i]);
                        if(response[i] === undefined) 
                            break;
                        result.push(response[i]['data']);
                    }
                });
        });

        return result;
    }


    async function getSensorDataFromTo(id,from,to)
    {
        if(to === undefined)
            return getSensorDataByIdStartingFrom(id,from);

        let result = [];
        var response;
        var last_record_number; 
        fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&limit=1&sensor_id="+id)
        .then(data=>
        {
            //console.log(data[0]);
            last_record_number = data[0]['sensor_data_id'];
            //console.log(last_record_number);
            fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&sensor_id="
                       +id+"&limit="+last_record_number+"&from="+from+"&to="+to)
            .then(data=>
                {
                    response = data;
                    for (var i = 0; i <= last_record_number; ++i) 
                    {
                        //console.log(response[i]);
                        if(response[i] === undefined) 
                            break;
                        result.push(response[i]['data']);
                    }
                });
        });

        return result;
    }

    async function getSensorRecordDateByIdFrom(id,from)
    {
        let result = [];
        var response;
        var last_record_number; 
        if(from === undefined)
            from = 0;        
        fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&limit=1&sensor_id="+id)
        .then(data=>
        {
            //console.log(data[0]);
            last_record_number = data[0]['sensor_data_id'];
            //console.log(last_record_number);

            fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&sensor_id="
                       +id+"&limit="+last_record_number+"&from="+from)
            .then(data=>
                {
                    response = data;
                    for (var i = 0; i <= last_record_number; ++i) 
                    {
                        //console.log(response[i]);
                        if(response[i] === undefined) 
                            break;
                        result.push(response[i]['date']);
                    }
                });
        });

        return result;        
    }

    async function getSensorRecordDateByIdFromTo(id,from,to)
    {
        let result = [];
        var response;
        var last_record_number; 
        if(to === undefined)
            return getSensorRecordDateByIdFrom(id,from);       
        fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&limit=1&sensor_id="+id)
        .then(data=>
        {
            //console.log(data[0]);
            last_record_number = data[0]['sensor_data_id'];
            //console.log(last_record_number);

            fetchAsync("https://smartgreen.cc/demo/api/api_GET.php?getSensorData&sensor_id="
                       +id+"&limit="+last_record_number+"&from="+from)
            .then(data=>
                {
                    response = data;
                    for (var i = 0; i <= last_record_number; ++i) 
                    {
                        //console.log(response[i]);
                        if(response[i] === undefined) 
                            break;
                        result.push(response[i]['date']);
                    }
                });
        });

        return result;               
    }


/*
  TL;DR mi qani funkcia(tochnee 2) irakanum avel a,
  haves ylni dranq haneq u en myusnery modifikacreq nenc,
  vor ashxaten nuyn dzev   
*/ 
