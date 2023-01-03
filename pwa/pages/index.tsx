import Head from "next/head";
import React, { useEffect, useState } from "react";
import "@fontsource/poppins";
import "@fontsource/poppins/600.css";
import "@fontsource/poppins/700.css";
import LineChart from "../components/D3/LineChart";
import BarChart from "../components/D3/BarChart";


const Welcome = () => {
  const [chart, setChart] = useState<string>("line");
  
  return (<div className="w-full overflow-x-hidden">
    <Head>
      <title>Welcome to Char vizualizer!</title>
    </Head>
    <select onChange={(e) => setChart(e.target.value)}>
      <option value={"line"}>
        LineChart
      </option>
      <option value={"bar"}>
        BarChart
      </option>
    </select>
    { chart == "line" ? <LineChart /> : <BarChart /> }
  </div>)
};
export default Welcome;
